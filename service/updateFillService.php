<?php
// Uncomment to debug POST array contents.
//var_dump($_POST);
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
$num = $_POST["serviceNum"];

try {
    $stmt = $db->prepare('SELECT * FROM service WHERE service_num = :num');
    $stmt->bindValue(':num', intval($num), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: No records in the database match this service number!";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // vin, employee_id, customer_id, dealership_id, service_date, service_cost
        $response = array("serviceNum" => $row["service_num"], "vin" => $row["vin"], "employeeID" => $row["employee_id"],
                          "customerID" => $row["customer_id"], "dealershipID" => $row["dealership_id"], 
                          "date" => $row["service_date"], "cost" => number_format($row["service_cost"], 2, ".", ""));
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
