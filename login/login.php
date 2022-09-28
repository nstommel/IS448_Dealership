<?php

$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$email = $_POST["email"];
$password = $_POST["password"];

$db->enableExceptions(true);
try {
    $result = $db->query('SELECT * FROM employee WHERE employee_email = "' . $email . '"');
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this employee email address.";
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        if($password === $row['employee_password']) {
            session_start();
            $_SESSION["employeeID"] = $row["employee_id"];
            $_SESSION["employeeRole"] = $row["employee_role"];
            
            echo "Password correct, welcome user: #" . $_SESSION["employeeID"] . " " 
                    . $row["employee_fname"] . " " . $row["employee_lname"] . ", " 
                    . $_SESSION["employeeRole"];
            
            $_SESSION["employeeID"] = $row["employee_id"];
            $_SESSION["employeeRole"] = $row["employee_role"];            
            exit();
        } else {
            header("HTTP/1.0 500 Internal Server Error");
            echo "Password incorrect, try again";
            die();
        }
    } 
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    die();
}
$db->close();
