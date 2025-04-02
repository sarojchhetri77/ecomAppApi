<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "DELETE") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["id"])) {
    sendResponse(false, "Product ID is required");
}

$id = $conn->real_escape_string($data["id"]);

// Delete product from the database
$sql = "DELETE FROM products WHERE id = '$id'";
if ($conn->query($sql)) {
    sendResponse(true, "Product deleted successfully");
} else {
    sendResponse(false, "Failed to delete product");
}

$conn->close();
?>
