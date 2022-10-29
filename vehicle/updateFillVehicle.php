<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
$vin = $_POST["vehicleVIN"];
try {
    $queryStr = "SELECT * FROM vehicle WHERE vin = '" . $vin . "'";
    $result = $db->query($queryStr);
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "Error: No records in the database match this ID!";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // vin, model_name, model_year, brand_name, color, msrp
        $response = array("vin" => $row["vin"], "model" => $row["model_name"],
                          "year" => $row["model_year"], "brand" => $row["brand_name"], 
                          "color" => $row["color"], "msrp" => number_format($row["msrp"], 2, ".", ""));
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
