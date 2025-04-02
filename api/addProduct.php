<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendResponse(false, "Invalid request method");
    exit;
}

// Check if the request is JSON or multipart/form-data
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? $_SERVER["CONTENT_TYPE"] : '';

if (strpos($contentType, "application/json") !== false) {
    $data = json_decode(file_get_contents("php://input"), true);
} else {
    $data = $_POST;
}

// Validate required fields
if (!isset($data["name"]) || !isset($data["price"]) || !isset($data["description"]) || !isset($data["categoryId"])) {
    sendResponse(false, "Name, price, description, and category_id are required");
    exit;
}

// Sanitize input data
$name = $conn->real_escape_string($data["name"]);
$price = $conn->real_escape_string($data["price"]);
$description = $conn->real_escape_string($data["description"]);
$category_id = $conn->real_escape_string($data["categoryId"]);

// Handle file upload (only if using multipart/form-data)
$imagePath = null;
if (!empty($_FILES["image"]["name"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
    $targetDir = "../uploads/";
    $imageName = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
        $imagePath = $imageName;
    } else {
        sendResponse(false, "Failed to upload image");
        exit;
    }
}

// Insert product into database
$sql = "INSERT INTO products (name, price, description, category_id, image) VALUES ('$name', '$price', '$description', '$category_id', '$imagePath')";
if ($conn->query($sql)) {
    sendResponse(true, "Product added successfully", ["product_id" => $conn->insert_id, "image" => $imagePath]);
} else {
    sendResponse(false, "Failed to add product");
}

$conn->close();
exit;
?>
