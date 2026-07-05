<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $sql = "INSERT INTO trip(full_name,email,phone)
            VALUES('$full_name','$email','$phone')";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}