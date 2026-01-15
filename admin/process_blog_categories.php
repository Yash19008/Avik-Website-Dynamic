<?php
include 'inc/db.php';
header('Content-Type: application/json');

/* SAVE */
if ($_POST['action'] === 'save') {
    try {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $parent = $_POST['parent_id'] ?? null;

        if ($name === '') {
            throw new Exception('Category name is required');
        }

        if ($id === $parent) {
            throw new Exception('Category cannot be its own parent');
        }

        if ($id === 0) {
            $sql = "INSERT INTO blog_categories (name,parent_id) VALUES ('$name',$parent)";
        } else {
            $sql = "UPDATE blog_categories SET name='$name', parent_id=$parent WHERE id=$id";
        }

        if (!mysqli_query($conn, $sql)) {
            throw new Exception('Database error');
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Category saved successfully'
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

/* DELETE */
if ($_POST['action'] === 'delete') {
    try {
        $id = (int)$_POST['delete_id'];

        $childCheck = mysqli_query($conn, "SELECT id FROM blog_categories WHERE parent_id=$id");
        if (mysqli_num_rows($childCheck) > 0) {
            throw new Exception('Delete child categories first');
        }

        mysqli_query($conn, "DELETE FROM blog_categories WHERE id=$id");

        echo json_encode(['status' => 'success']);
        exit;
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        exit;
    }
}
