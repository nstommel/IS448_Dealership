<?php
// Uncomment to debug POST array contents.
//var_dump($_POST);
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
$snum = $_POST["saleNum"];

try {
    $stmt = $db->prepare('SELECT * FROM sale WHERE sale_num = :snum');
    $stmt->bindValue(':snum', intval($snum), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: No records in the database match this sale number!";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // vin, employee_id, customer_id, dealership_id, sale_date, sale_cost
        $response = array("saleNum" => $row["sale_num"], "vin" => $row["vin"], "employeeID" => $row["employee_id"],
                          "customerID" => $row["customer_id"], "dealershipID" => $row["dealership_id"], 
                          "date" => $row["sale_date"], "cost" => number_format($row["sale_cost"], 2, ".", ""));
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
