<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

$host = "localhost";
$username = "root";
$password = "";
$database = "wwec";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed.");
}

// Set charset
// $conn->set_charset("utf8mb4");
