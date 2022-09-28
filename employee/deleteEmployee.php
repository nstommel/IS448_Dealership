<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$id = $_POST["employeeID"];

$db->enableExceptions(true);
try {
    if($_SESSION["employeeRole"] === "Manager") {
        $result = $db->query('SELECT * FROM employee WHERE employee_id = "' . $id . '"');
        if(!$result->fetchArray()) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "No records match this employee ID, cannot delete.";
            $db->close();
            die();
        } else {
            $db->exec('DELETE FROM employee WHERE employee_id = ' . $id); 
            echo "Successfully deleted employee record in database!";
            $db->close();
            exit();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to delete an employee in the database.";
        $db->close();
        exit();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    if (str_contains($e->getMessage(), "FOREIGN KEY constraint failed")) {
        echo "Employee has associated sales or services, deleting aborted.\n"
                . "Please remove these records before attempting deletion.";
    } else {
        echo "A different database error occurred: " . $e->getMessage();
    }
    $db->close();
    die();
}