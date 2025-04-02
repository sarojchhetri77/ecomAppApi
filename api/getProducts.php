<?php
require_once "../config/headers.php";
require_once "../config/db.php";
require_once "../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendResponse(false, "Invalid request method");
}
$baseUrl = "http://localhost/newphpapi/uploads/";

$sql = "SELECT products.id, products.name, products.price, products.description,products.image, categories.id AS categoryId, categories.category AS category_name 
        FROM products 
        JOIN categories ON products.category_id = categories.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $row['image'] = !empty($row['image']) ? $baseUrl . $row['image'] : null;
        $products[] = $row;
    }
    sendResponse(true,"Products retrieved successfully", ["products" => $products]);
} else {
    sendResponse(false,"No products found");
}

$conn->close();
?>
