<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method");
}

$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data["user_id"]) || !isset($data["product_ids"]) || !isset($data["quantities"])) {
    sendResponse(false, "User ID, product IDs, and quantities are required");
}

$user_id = $conn->real_escape_string($data["user_id"]);
$product_ids = $conn->real_escape_string(implode(",", $data["product_ids"]));
$quantities = $conn->real_escape_string(implode(",", $data["quantities"]));

$sql = "INSERT INTO orders (user_id, product_ids, quantities, status) VALUES ('$user_id', '$product_ids', '$quantities', 'Pending')";
if ($conn->query($sql)) {
    sendResponse(true, "Order placed successfully", ["order_id" => $conn->insert_id]);
} else {
    sendResponse(false, "Failed to place order");
}

$conn->close();
?>
