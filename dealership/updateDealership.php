<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$id = $_POST["dealershipID"];
$name = trim($_POST["name"]);
$city = trim($_POST["city"]);
$state = trim($_POST["state"]);
$phone = trim($_POST["phone"]);

$db->enableExceptions(true);
try {
    if($_SESSION["employeeRole"] === "Manager") {        
        $stmt = $db->prepare('SELECT * FROM dealership WHERE dealership_id = :id');
        $stmt->bindValue(':id', intval($id), SQLITE3_INTEGER);
        $result = $stmt->execute();
        if(!$result->fetchArray()) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "No records match this vehicle ID #, cannot update.";
            $db->close();
            die();
        } else {
            $result->reset();
            // dealership_id, dealership_name, dealership_city, dealership_state, dealership_phone
            $queryStr = 'UPDATE dealership SET dealership_name = :name, dealership_city = :city, ' .
                        'dealership_state = :state, dealership_phone = :phone ' .
                        'WHERE dealership_id = :id';
            $stmt = $db->prepare($queryStr);
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':city', $city, SQLITE3_TEXT);
            $stmt->bindValue(':state', $state, SQLITE3_TEXT);
            $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);
            $stmt->bindValue(':id', intval($id), SQLITE3_INTEGER);
            $stmt->execute();
            echo "Successfully updated record in database!";
            $db->close();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to update a dealership into the database.";
        $db->close();
        die();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}

