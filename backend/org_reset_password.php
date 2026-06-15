<?php
require_once 'db.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['new_password']) || (!isset($data['org_id']) && !isset($data['email']))) {
    echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    exit;
}

$new_password = password_hash($data['new_password'], PASSWORD_DEFAULT);

if (isset($data['org_id'])) {
    $org_id = $conn->real_escape_string($data['org_id']);
    $sql = "UPDATE organizations SET password='$new_password' WHERE id='$org_id'";
} else {
    $email = $conn->real_escape_string($data['email']);
    $sql = "UPDATE organizations SET password='$new_password' WHERE email='$email'";
}

if ($conn->query($sql) === TRUE) {
    if ($conn->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Password updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Organization not found or password is the same"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
}

$conn->close();
?>
