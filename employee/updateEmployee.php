<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$employee_id = $_POST["employeeID"];
$dealership_id = $_POST["dealershipID"];
$fname = trim($_POST["employeeFname"]);
$lname = trim($_POST["employeeLname"]);
$email = trim($_POST["employeeEmail"]);
$phone = trim($_POST["employeePhone"]);
$role = $_POST["employeeRole"];

$db->enableExceptions(true);
try {
    if($_SESSION["employeeRole"] === "Manager") {
        $result = $db->query('SELECT * FROM employee WHERE employee_id = "' . $employee_id . '"');
        if(!$result->fetchArray()) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "No records match this employee ID, cannot update.";
            $db->close();
            die();
        } else {
            $result->reset();
            $db->exec('UPDATE employee SET dealership_id = ' . $dealership_id . ', employee_fname = "' 
                    . $fname .'", employee_lname = "' . $lname . '", employee_email = LOWER("' . $email 
                    . '"), employee_phone = "' . $phone . '", employee_role = "' . $role . '" ' 
                    . 'WHERE employee_id = "' . $employee_id . '"'); 
            echo "Successfully updated record in database!";
            $db->close();
            exit();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to update an employee in the database.";
        $db->close();
        exit();
    }  
} catch (Exception $e) {
    if(str_contains($e->getMessage(), "UNIQUE constraint failed")) {
        echo "This email address is already in use by another employee.\n"
            . "Please enter a different email address.\n";
    }
    if(str_contains($e->getMessage(), "FOREIGN KEY constraint failed")) {
        echo "The dealership ID provided does not exist in the database.\n"
            . "Please enter a different dealership ID.\n";
    }
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}
