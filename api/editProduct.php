<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["id"]) || !isset($data["name"]) || !isset($data["price"]) || !isset($data["description"]) || !isset($data["category_id"])) {
    sendResponse(false, "ID, name, price, description, and category_id are required");
}

$id = $conn->real_escape_string($data["id"]);
$name = $conn->real_escape_string($data["name"]);
$price = $conn->real_escape_string($data["price"]);
$description = $conn->real_escape_string($data["description"]);
$category_id = $conn->real_escape_string($data["category_id"]);

$sql = "UPDATE products SET name = '$name', price = '$price', description = '$description', category_id = '$category_id' WHERE id = '$id'";
if ($conn->query($sql)) {
    sendResponse(true, "Product updated successfully");
} else {
    sendResponse(false, "Failed to update product");
}

$conn->close();
?>
