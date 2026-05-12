<?php

$host = "localhost";
$user = "root";
$pass = "Oscar112415@25";
$db   = "kingscup";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

/* UTF-8 */
mysqli_set_charset($conn, "utf8mb4");
?>