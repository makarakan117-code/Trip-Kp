

<?php

    $conn = new mysqli('localhost', 'root', '', 'php_3_5');
if ($conn->connect_error) {
    die('Connection Failed: ' . $conn->connect_error);
}