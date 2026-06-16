<?php
// Suppress warnings so they don't break JSON output
error_reporting(0);
ini_set('display_errors', 0);
mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password is empty
$dbname = "civicbin";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    // Headers for error response
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    die(json_encode(["status" => "error", "message" => "Database connection failed"]));
}
?>
