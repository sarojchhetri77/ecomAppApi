<?php
$servername = "localhost";
$username = "ecom_api";
$password = "password";  
$dbname = "ecomApi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
?>
