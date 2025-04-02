<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["order_id"]) || !isset($data["status"])) {
    sendResponse(false, "Order ID and status are required");
}

$order_id = $conn->real_escape_string($data["order_id"]);
$status = $conn->real_escape_string($data["status"]);

$sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
if ($conn->query($sql)) {
    sendResponse(true, "Order status updated successfully");
} else {
    sendResponse(false, "Failed to update order status");
}

$conn->close();
?>
