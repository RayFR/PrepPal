<?php
// Student & ID: sazidun sami hossain mohammed (240160816)
// Role: database + backend
// File: connectdb.php
// Description: Connects the database with the backend logic.
// Date: Nov 2025

$host = "localhost";
$dbname = "preppal";
$username = "root";
// IMPORTANT: If your root user requires a password, you MUST enter it here!
$password = ""; // sami 

try {
    // Attempt database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set content type for scripts that require this file (like login_admin.php)
    header('Content-Type: application/json');
    
} catch (PDOException $e) {
    // If connection fails, immediately output a JSON error and stop execution.
    // This is the correct way to handle the error for the JavaScript client.
    http_response_code(500); // Internal Server Error
    die(json_encode(["success" => false, "error" => "Database connection failed: " . $e->getMessage()]));
}