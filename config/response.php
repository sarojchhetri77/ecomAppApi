<?php
function sendResponse($success, $message, $data = []) {
    echo json_encode(array_merge(
        ["success" => $success, "message" => $message],
        $data
    ));
    exit;
}
?>
