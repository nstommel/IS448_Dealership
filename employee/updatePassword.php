<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$employee_id = $_SESSION["employeeID"];
$password = trim($_POST["password"]);

$db->enableExceptions(true);
try {    
    $db->exec('UPDATE employee SET employee_password = "' . $password . 
                '" WHERE employee_id = ' . $employee_id); 
    echo "Successfully updated password in database!";
    $db->close();
    exit();
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}