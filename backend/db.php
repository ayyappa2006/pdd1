<?php
// Suppress warnings so they don't break JSON output
error_reporting(0);
ini_set('display_errors', 0);
mysqli_report(MYSQLI_REPORT_OFF);

$host = "127.0.0.1";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password is empty
$dbname = "civicbin";

// Try port 3307 first (common for custom XAMPP configurations), then fall back to default port (3306)
$port = 3307;
$conn = @new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    // Fall back to default port (usually 3306)
    $conn = @new mysqli($host, $username, $password, $dbname);
}

if ($conn->connect_error) {
    // Headers for error response
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
?>
