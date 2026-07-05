<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = $_POST['user_id'];
    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "UPDATE trip
            SET
                full_name='$name',
                email='$email',
                phone='$phone'
            WHERE user_id=$id";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo $conn->error;
    }
}
?>