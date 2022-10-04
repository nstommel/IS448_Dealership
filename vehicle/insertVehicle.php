<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$model = trim($_POST["vehicleModel"]);
$year = intval($_POST["vehicleYear"]);
$brand = trim($_POST["vehicleBrand"]);
$color = trim($_POST["vehicleColor"]);
//Trim the dollar sign off of the vehicle MSRP input before insertion.
$msrp = floatval(str_replace('$', '', trim($_POST["vehicleMSRP"])));

$db->enableExceptions(true);
try {
    //Attempt insert into database
    // vin (autoincrement), model_name, model_year, brand_name, color, msrp
    $queryStr = 'INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)' . 
                'VALUES(:model, :year, :brand, :color, :msrp)';
    $stmt = $db->prepare($queryStr);
    $stmt->bindValue(':model', $model, SQLITE3_TEXT);
    $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
    $stmt->bindValue(':brand', $brand, SQLITE3_TEXT);
    $stmt->bindValue(':color', $color, SQLITE3_TEXT);
    $stmt->bindValue(':msrp', $msrp, SQLITE3_FLOAT);
    $stmt->execute();
    echo "Successfully inserted into database, assigned vehicle ID #: " . $db->lastinsertRowID();
    $db->close();
    exit();
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}
