<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
$employeeID = $_POST["employeeID"];
try {
    $queryStr = "SELECT * FROM employee WHERE employee_id = '" . $employeeID . "'";
    $result = $db->query($queryStr);
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: No records in the database match this ID!";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        $response = array("employeeID" => $row["employee_id"], "dealershipID" => $row["dealership_id"], "fname" => $row["employee_fname"],
                          "lname" => $row["employee_lname"], "email" => $row["employee_email"], 
                          "phone" => $row["employee_phone"], "role" => $row["employee_role"]);
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