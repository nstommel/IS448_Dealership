<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$id = $_POST["dealershipID"];

$db->enableExceptions(true);
try {
    if($_SESSION["employeeRole"] === "Manager") {
        $stmt = $db->prepare('SELECT * FROM dealership WHERE dealership_id = :id');
        $stmt->bindValue(':id', intval($id), SQLITE3_INTEGER);
        $result = $stmt->execute();
        if(!$result->fetchArray()) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "No records match this dealership ID, cannot delete.";
            $db->close();
            die();
        } else {
            $stmt = $db->prepare('DELETE FROM dealership WHERE dealership_id = :id');
            $stmt->bindValue(':id', intval($id), SQLITE3_INTEGER);
            $result = $stmt->execute();
            echo "Successfully deleted dealership record in database!";
            $db->close();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to delete a dealership from the database.";
        $db->close();
        die();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    if (str_contains($e->getMessage(), "FOREIGN KEY constraint failed")) {
        echo "Dealership has associated employees, sales, or services, deleting aborted.\n"
                . "Please remove these records before attempting deletion.";
    } else {
        echo "A different database error occurred: " . $e->getMessage();
    }
    $db->close();
    die();
}