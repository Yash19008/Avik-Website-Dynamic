<?php
include 'inc/db.php';
header('Content-Type: application/json');

$uploadDir = 'uploads/blogs/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

if ($_POST['action'] === 'save') {
    try {
        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title']);
        $slug = trim($_POST['slug']);
        $cat = (int)$_POST['cat_id'];
        $content = $_POST['content'];
        $tags = trim($_POST['tags']);
        $added_by = 1;
        $old = $_POST['old_image'] ?? '';

        if ($title == '' || $cat == 0) throw new Exception('Required fields missing');

        if ($slug == '') {
            $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($title));
        }

        /* SLUG UNIQUENESS */
        $slug = mysqli_real_escape_string($conn, $slug);

        $checkSql = "SELECT id FROM blogs WHERE slug='$slug'";
        if ($id > 0) {
            $checkSql .= " AND id != $id";
        }

        $check = mysqli_query($conn, $checkSql);
        if (mysqli_num_rows($check) > 0) {
            throw new Exception('Slug already exists. Please use a different one.');
        }

        if (!empty($_FILES['bg_image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['bg_image']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) throw new Exception('Invalid image');
            $name = time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['bg_image']['tmp_name'], $uploadDir . $name);
            $bg = $uploadDir . $name;
            if ($old && file_exists($old)) unlink($old);
        } else {
            $bg = $old;
        }

        if ($id == 0) {
            mysqli_query($conn, "INSERT INTO blogs 
        (slug,title,cat_id,bg_image,content,tags,added_by)
        VALUES ('$slug','$title',$cat,'$bg','$content','$tags',$added_by)");
        } else {
            mysqli_query($conn, "UPDATE blogs SET
        slug='$slug',title='$title',cat_id=$cat,
        bg_image='$bg',content='$content',tags='$tags'
        WHERE id=$id");
        }

        echo json_encode(['status' => 'success', 'message' => 'Blog saved']);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}

/* DELETE */
if ($_POST['action'] === 'delete') {
    $id = (int)$_POST['id'];
    $res = mysqli_query($conn, "SELECT bg_image FROM blogs WHERE id=$id");
    $row = mysqli_fetch_assoc($res);
    if ($row && file_exists($row['bg_image'])) unlink($row['bg_image']);
    mysqli_query($conn, "DELETE FROM blogs WHERE id=$id");
    echo json_encode(['status' => 'success']);
}
