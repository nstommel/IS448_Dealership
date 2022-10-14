<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
$id = $_POST["dealershipID"];
try {
    $stmt = $db->prepare('SELECT * FROM dealership WHERE dealership_id = :id');
    $stmt->bindValue(':id', intval($id), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: No records in the database match this ID!";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // dealership_id, dealership_name, dealership_city, dealership_state, dealership_phone
        $response = array("id" => $row["dealership_id"], "name" => $row["dealership_name"],
                          "city" => $row["dealership_city"], "state" => $row["dealership_state"], 
                          "phone" => $row["dealership_phone"]);
        echo json_encode($response);
        $db->close();
        exit();
    }
} catch(Exception $e) {
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}

