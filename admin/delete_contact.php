<?php
include 'inc/db.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $query = "DELETE FROM contacts WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error";
    }
}
