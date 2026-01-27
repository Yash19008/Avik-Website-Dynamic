<?php
include 'inc/db.php';
header('Content-Type: application/json');

$uploadDir = 'uploads/works/';
$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
$baseUrl .= "admin/";
$maxSize = 5 * 1024 * 1024;
$allowed = ['jpg', 'jpeg', 'png', 'webp'];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* SAVE */
if ($_POST['action'] === 'save') {
    try {
        $id = (int)($_POST['id'] ?? 0);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $location = mysqli_real_escape_string($conn, $_POST['location']);
        $oldImage = $_POST['old_image'] ?? '';

        if (!empty($_FILES['image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                throw new Exception('Invalid image type');
            }

            if ($_FILES['image']['size'] > $maxSize) {
                throw new Exception('Image too large');
            }

            $newName = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $newName);
            $image = $baseUrl . $uploadDir . $newName;

            if ($oldImage) {
                $path = str_replace($baseUrl, '', $oldImage);
                if (file_exists($path)) unlink($path);
            }
        } else {
            if ($id == 0) throw new Exception('Image required');
            $image = $oldImage;
        }

        if ($id == 0) {
            mysqli_query($conn, "INSERT INTO works (name, location, image) VALUES ('$name','$location','$image')");
        } else {
            mysqli_query($conn, "UPDATE works SET name='$name', location='$location', image='$image' WHERE id=$id");
        }

        echo json_encode(['status' => 'success', 'message' => 'Saved successfully']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

/* DELETE */
if ($_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $res = mysqli_query($conn, "SELECT image FROM works WHERE id=$id");
    $row = mysqli_fetch_assoc($res);

    if ($row) {
        $path = str_replace($baseUrl, '', $row['image']);
        if (file_exists($path)) unlink($path);
        mysqli_query($conn, "DELETE FROM works WHERE id=$id");
    }

    echo json_encode(['status' => 'success']);
}
