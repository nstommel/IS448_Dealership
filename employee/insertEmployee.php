<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

//$customer_fname = "John";
//$customer_lname = "Smith";
//$customer_email = "jsmith@gmail.com";
//$customer_phone = "443-492-7045";
//customer_fname, customer_lname, customer_email, customer_phone
$dealership_id = $_POST["dealershipID"];
$fname = trim($_POST["employeeFname"]);
$lname = trim($_POST["employeeLname"]);
$email = trim($_POST["employeeEmail"]);
$phone = trim($_POST["employeePhone"]);
$role = $_POST["employeeRole"];
$password = trim($_POST["employeePassword"]);

$db->enableExceptions(true);
try {
    //Attempt insert into database
    if($_SESSION["employeeRole"] === "Manager") {
        $db->exec('INSERT INTO employee (dealership_id, employee_fname, employee_lname, ' . 
                  'employee_email, employee_phone, employee_role, employee_password)' .
                  'VALUES (' . $dealership_id . ', "' . $fname . '", "' . $lname . 
                  '", LOWER("' . $email . '"), "' . $phone . '", "' . $role . '", "' . 
                  $password . '")');
        echo "Successfully inserted into database, assigned employee ID #: " . $db->lastinsertRowID();
        $db->close();
        exit();
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to add an employee to the database";
        $db->close();
        exit();
    }
    
} catch (Exception $e) {
    $message = $e->getMessage();
    if(str_contains($message, "UNIQUE constraint failed")) {
        echo "This email is already in use, please enter a different email.\n";
    } elseif (str_contains ($message, "FOREIGN KEY constraint failed")) {
        echo "This dealership ID does not refer to an extant dealership.\n";
    } else {
        echo "A different error occurred during the insertion attempt.\n";
    }
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}


