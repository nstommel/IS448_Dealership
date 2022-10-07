<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$name = trim($_POST["name"]);
$city = trim($_POST["city"]);
$state = trim($_POST["state"]);
$phone = trim($_POST["phone"]);

$db->enableExceptions(true);
try {
    if($_SESSION["employeeRole"] === "Manager") {        
        // Attempt insert into database
        // dealership_id (autoincrement), dealership_name, dealership_city, dealership_state, dealership_phone
        $queryStr = 'INSERT INTO dealership (dealership_name, dealership_city, dealership_state, dealership_phone)' . 
                    'VALUES (:name, :city, :state, :phone)';
        $stmt = $db->prepare($queryStr);
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $stmt->bindValue(':city', $city, SQLITE3_TEXT);
        $stmt->bindValue(':state', $state, SQLITE3_TEXT);
        $stmt->bindValue(':phone', $phone, SQLITE3_TEXT);        
        $stmt->execute();
        echo "Successfully inserted into database, assigned dealership ID #: " . $db->lastinsertRowID();
        $db->close();
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to insert a dealership into the database.";
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
