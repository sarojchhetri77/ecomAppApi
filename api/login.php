<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method");
}
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["email"]) || !isset($data["password"])) {
    sendResponse(false, "Email and password are required");
}

$email = $conn->real_escape_string($data["email"]);
$password = $data["password"];

$sql = "SELECT id,is_admin,name,email,address,phone, password FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password"])) {
        sendResponse(true, "Login successful", [
            "user" => [
                "id" => $user["id"],
                "name" => $user["name"],
                "email" =>$user["email"],
                "phone" => $user["phone"],
                "address" => $user["address"],
                "is_admin" => $user["is_admin"]
            ]
        ]);
            } else {
        sendResponse(false, "Invalid credentials");
    }
} else {
    sendResponse(false, "User not found");
}

$conn->close();
?>
