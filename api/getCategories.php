<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendResponse(false, "Invalid request method");
}

// Get all categories
$sql = "SELECT id, category FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    sendResponse(true, "Categories retrieved successfully", ["categories" => $categories]);
} else {
    sendResponse(false, "No categories found");
}

$conn->close();
?>
