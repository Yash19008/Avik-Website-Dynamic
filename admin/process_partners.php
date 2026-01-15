<?php
include 'inc/db.php';

header('Content-Type: application/json');

/* CONFIG */
$uploadDir = 'uploads/partners/';
$allowedTypes = ['jpg', 'jpeg', 'png', 'webp'];
$maxSize = 2 * 1024 * 1024; // 2MB

/* Ensure upload directory exists */
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* ===========================
   ADD / UPDATE PARTNER
=========================== */
if (isset($_POST['action']) && $_POST['action'] === 'save') {

    $id        = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $oldImage = $_POST['old_image'] ?? '';

    try {

        /* ADD requires image */
        if ($id === 0 && empty($_FILES['image']['name'])) {
            throw new Exception('Partner logo is required');
        }

        /* IMAGE VALIDATION */
        if (!empty($_FILES['image']['name'])) {

            if ($_FILES['image']['error'] !== 0) {
                throw new Exception('File upload error');
            }

            if ($_FILES['image']['size'] > $maxSize) {
                throw new Exception('Image size must be under 2MB');
            }

            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, $allowedTypes)) {
                throw new Exception('Invalid image format (jpg, png, webp only)');
            }

            $newName = time() . '_' . uniqid() . '.' . $ext;
            $targetPath = $uploadDir . $newName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                throw new Exception('Failed to upload image');
            }

            /* Remove old image on update */
            if ($id > 0 && $oldImage && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }
        } else {
            $newName = $oldImage;
        }

        /* DATABASE */
        if ($id === 0) {
            $sql = "INSERT INTO partners (image) VALUES ('$newName')";
        } else {
            $sql = "UPDATE partners SET image='$newName' WHERE id=$id";
        }

        if (!mysqli_query($conn, $sql)) {
            throw new Exception('Database error');
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Partner saved successfully'
        ]);
        exit;
    } catch (Exception $e) {

        /* Cleanup failed upload */
        if (!empty($newName) && file_exists($uploadDir . $newName)) {
            unlink($uploadDir . $newName);
        }

        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
}

/* ===========================
   DELETE PARTNER
=========================== */
if (isset($_POST['action']) && $_POST['action'] === 'delete') {

    $id = (int)$_POST['delete_id'];

    try {

        if ($id <= 0) {
            throw new Exception('Invalid partner ID');
        }

        $res = mysqli_query($conn, "SELECT image FROM partners WHERE id=$id");
        if (!$res || mysqli_num_rows($res) === 0) {
            throw new Exception('Partner not found');
        }

        $row = mysqli_fetch_assoc($res);

        if ($row['image'] && file_exists($uploadDir . $row['image'])) {
            unlink($uploadDir . $row['image']);
        }

        if (!mysqli_query($conn, "DELETE FROM partners WHERE id=$id")) {
            throw new Exception('Failed to delete partner');
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Partner deleted'
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
}
