<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
$customerID = $_POST["customerID"];
try {
    $queryStr = "SELECT * FROM customer WHERE customer_id = '" . $customerID . "'";
    $result = $db->query($queryStr);
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: No records in the database match this ID!";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        $response = array("id" => $row["customer_id"], "fname" => $row["customer_fname"],
                          "lname" => $row["customer_lname"], "email" => $row["customer_email"], 
                          "phone" => $row["customer_phone"]);
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
