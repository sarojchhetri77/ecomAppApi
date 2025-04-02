<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["id"]) || !isset($data["category"])) {
    sendResponse(false, "ID and category are required");
}

$id = $conn->real_escape_string($data["id"]);
$category = $conn->real_escape_string($data["category"]);

$sql = "UPDATE categories SET category = '$category' WHERE id = '$id'";
if ($conn->query($sql)) {
    sendResponse(true, "Category updated successfully");
} else {
    sendResponse(false, "Failed to update category");
}

$conn->close();
?>
