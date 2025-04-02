<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["category"])) {
    sendResponse(false,"Category category is required");
}

$category = $conn->real_escape_string($data["category"]);

$sql = "INSERT INTO categories (category) VALUES ('$category')";
if ($conn->query($sql)) {
    sendResponse(true, "Category added successfully", ["category_id" => $conn->insert_id]);
} else {
    sendResponse(false, "Failed to add category");
}

$conn->close();
?>
