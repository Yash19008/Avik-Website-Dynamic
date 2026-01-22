<?php
include 'inc/db.php';
header('Content-Type: application/json');

$baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

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
        $featured = isset($_POST['featured']) ? (int)$_POST['featured'] : 0;

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
            $link = $baseUrl . $uploadDir . $newName;

            if ($id && $old && file_exists($old)) unlink($old);
        } elseif (filter_var($url, FILTER_VALIDATE_URL)) {
            $link = $url;
        } else {
            throw new Exception('Upload file or provide valid URL');
        }

        if ($id == 0) {
            mysqli_query($conn, "INSERT INTO gallery (type, link, featured) VALUES ('$type', '$link', $featured)");
        } else {
            mysqli_query($conn, "UPDATE gallery SET type='$type', link='$link', featured=$featured WHERE id=$id");
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

    $path = str_replace($baseUrl, '', $row['link']);
    if ($row && file_exists($path)) unlink($path);

    mysqli_query($conn, "DELETE FROM gallery WHERE id=$id");

    echo json_encode(['status' => 'success']);
}
