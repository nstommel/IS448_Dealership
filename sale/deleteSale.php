<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$num = $_POST["saleNum"];

$db->enableExceptions(true);
try {
    if($_SESSION["employeeRole"] === "Salesperson" || $_SESSION["employeeRole"] === "Manager") {
        $stmt = $db->prepare('SELECT * FROM sale WHERE sale_num = :num');
        $stmt->bindValue(':num', intval($num), SQLITE3_INTEGER);
        $result = $stmt->execute();
        if(!$result->fetchArray()) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "No records match this sale order number, cannot delete.";
            $db->close();
            die();
        } else {
            $stmt = $db->prepare('DELETE FROM sale WHERE sale_num = :num');
            $stmt->bindValue(':num', intval($num), SQLITE3_INTEGER);
            $result = $stmt->execute();
            echo "Successfully deleted sale order in database!";
            $db->close();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: You do not have sufficient permissions as a " . $_SESSION["employeeRole"] . 
             " to delete a sale order from the database.";
        $db->close();
        die();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error occurred: " . $e->getMessage();
    $db->close();
    die();
}
