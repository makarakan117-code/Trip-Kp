<?php
require_once "db.php";

if (isset($_GET['id'])) {

    $id = $_GET['id'];

    $sql = "DELETE FROM trip WHERE user_id = $id";

    if ($conn->query($sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Delete failed: " . $conn->error;
    }

} else {
    header("Location: index.php");
    exit;
}
?>