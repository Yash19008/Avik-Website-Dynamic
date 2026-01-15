<?php
include 'inc/db.php';
header('Content-Type: application/json');

$uploadDir = 'uploads/gallery/';
$maxSize = 10 * 1024 * 1024;
$imageTypes = ['jpg', 'jpeg', 'png', 'webp'];
$videoTypes = ['mp4', 'webm', 'ogg'];

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

/* SAVE */
if ($_POST['action'] == 'save') {
    try {
        $id   = (int)($_POST['id'] ?? 0);
        $type = $_POST['type'] ?? '';
        $old  = $_POST['old_link'] ?? '';
        $url  = trim($_POST['link'] ?? '');

        if (!in_array($type, ['image', 'video'])) {
            throw new Exception('Invalid type');
        }

        /* FILE OR LINK */
        if (!empty($_FILES['file']['name'])) {
            $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
            $allowed = $type == 'image' ? $imageTypes : $videoTypes;

            if (!in_array($ext, $allowed)) {
                throw new Exception('Invalid file type');
            }

            if ($_FILES['file']['size'] > $maxSize) {
                throw new Exception('File too large');
            }

            $newName = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $newName);
            $link = $uploadDir . $newName;

            if ($id && $old && file_exists($old)) unlink($old);
        } elseif (filter_var($url, FILTER_VALIDATE_URL)) {
            $link = $url;
        } else {
            throw new Exception('Upload file or provide valid URL');
        }

        if ($id == 0) {
            mysqli_query($conn, "INSERT INTO gallery (type,link) VALUES ('$type','$link')");
        } else {
            mysqli_query($conn, "UPDATE gallery SET type='$type', link='$link' WHERE id=$id");
        }

        echo json_encode(['status' => 'success', 'message' => 'Saved successfully']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}

/* DELETE */
if ($_POST['action'] == 'delete') {
    $id = (int)$_POST['delete_id'];
    $res = mysqli_query($conn, "SELECT link FROM gallery WHERE id=$id");
    $row = mysqli_fetch_assoc($res);

    if ($row && file_exists($row['link'])) unlink($row['link']);
    mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");

    echo json_encode(['status' => 'success']);
}
