<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["email"]) || !isset($data["password"]) || !isset($data["address"]) || !isset($data["phone"]) || !isset($data["name"])) {
    sendResponse(false, "Email password are required");
}

$email = $conn->real_escape_string($data["email"]);
$name = $conn->real_escape_string($data["name"]);
$address = $conn->real_escape_string($data["address"]);
$phone = $conn->real_escape_string($data["phone"]);
$password = password_hash($data["password"], PASSWORD_DEFAULT);

// Check if user already exists
$check_sql = "SELECT id FROM users WHERE email = '$email'";
$check_result = $conn->query($check_sql);
if ($check_result->num_rows > 0) {
    sendResponse(false, "Email is already registered");
}

// Insert new user
$sql = "INSERT INTO users (name,address,email, password,phone) VALUES ('$name','$address','$email', '$password','$phone')";
if ($conn->query($sql)) {
    sendResponse(true, "Signup successful", ["user_id" => $conn->insert_id]);
} else {
    sendResponse(false, "Signup failed, please try again");
}

$conn->close();
?>
