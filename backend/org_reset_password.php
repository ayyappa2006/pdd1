<?php
// CORS headers FIRST — before any output
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

// Handle OPTIONS preflight request (sent by browsers and Android before POST)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Method not allowed"]);
    exit;
}

require_once 'db.php';

// Read raw JSON body
$rawInput = file_get_contents("php://input");
$data = json_decode($rawInput, true);

// Validate required fields
if (!isset($data['new_password']) || empty(trim($data['new_password']))) {
    echo json_encode(["status" => "error", "message" => "New password is required"]);
    exit;
}

if (!isset($data['email']) || empty(trim($data['email']))) {
    echo json_encode(["status" => "error", "message" => "Email address is required"]);
    exit;
}

$email        = $conn->real_escape_string(trim($data['email']));
$new_password = password_hash(trim($data['new_password']), PASSWORD_DEFAULT);

// First check if organization exists
$checkSql = "SELECT id FROM organizations WHERE email = '$email'";
$checkResult = $conn->query($checkSql);

if (!$checkResult || $checkResult->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "No organization account found with that email address"]);
    $conn->close();
    exit;
}

// Update password
$sql = "UPDATE organizations SET password='$new_password' WHERE email='$email'";

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Password updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Password update failed. Please try again."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
}

$conn->close();
?>
