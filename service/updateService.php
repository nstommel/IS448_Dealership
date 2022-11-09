<?php
// Uncomment to debug POST array contents.
// var_dump($_POST);
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$snum = $_POST["serviceNum"];
$vin = $_POST["VIN"];
$employeeID = $_POST["employeeID"];
$customerID = $_POST["customerID"];
$dealershipID = $_POST["dealershipID"];
$date = trim($_POST["date"]);
$cost = $_POST["cost"];

$db->enableExceptions(true);
try {
    if ($_SESSION["employeeRole"] === "Manager" || $_SESSION["employeeRole"] === "Mechanic") {
        $stmt = $db->prepare('SELECT * FROM service WHERE service_num = :snum');
        $stmt->bindValue(':snum', intval($snum), SQLITE3_INTEGER);
        $result = $stmt->execute();
        if(!$result->fetchArray()) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "No records match this service number, cannot update.";
            $db->close();
            die();
        } else {
            // Attempt insert into database
            $result->reset();
            // vin, employee_id, customer_id, dealership_id, service_date, service_cost
            $queryStr = 'UPDATE service SET vin = :vin, employee_id = :eid, ' . 
                    'customer_id = :cid, dealership_id = :did, service_date = :date, ' .
                    'service_cost = :cost WHERE service_num = :snum';
            $stmt = $db->prepare($queryStr);
            $stmt->bindValue(':vin', intval($vin), SQLITE3_INTEGER);
            $stmt->bindValue(':eid', intval($employeeID), SQLITE3_INTEGER);
            $stmt->bindValue(':cid', intval($customerID), SQLITE3_INTEGER);
            $stmt->bindValue(':did', intval($dealershipID), SQLITE3_INTEGER);
            $stmt->bindValue(':date', $date, SQLITE3_TEXT);
            $stmt->bindValue(':cost', floatval($cost), SQLITE3_FLOAT);
            $stmt->bindValue(':snum', intval($snum), SQLITE3_INTEGER);
            $stmt->execute();
            echo "Successfully updated service record #" . $snum;
            $db->close();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to update a service job in the database.";
        $db->close();
        die();
    }
} catch (Exception $e) {
    // Print out all fields that may have caused the error when executing insert operation.
    $stmt = $db->prepare('SELECT * FROM vehicle WHERE vin = :vin');
    $stmt->bindValue(':vin', intval($vin), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        echo "Vehicle ID does not exist in database.\n";
    }
    $stmt = $db->prepare('SELECT * FROM employee WHERE employee_id = :eid');
    $stmt->bindValue(':eid', intval($employeeID), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        echo "Employee ID does not exist in database.\n";
    }
    $stmt = $db->prepare('SELECT * FROM customer WHERE customer_id = :cid');
    $stmt->bindValue(':cid', intval($customerID), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        echo "Customer ID does not exist in database.\n";
    }
    $stmt = $db->prepare('SELECT * FROM dealership WHERE dealership_id = :did');
    $stmt->bindValue(':did', intval($dealershipID), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        echo "Dealership ID does not exist in database.\n";
    }
    echo "Database error ecountered, insert failed:\n" . $e->getMessage();
    $db->close();
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    die();
}
