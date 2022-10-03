<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$model = trim($_POST["vehicleModel"]);
$year = $_POST["vehicleYear"];
$brand = trim($_POST["vehicleBrand"]);
$color = trim($_POST["vehicleColor"]);
//Trim the dollar sign off of the vehicle MSRP input before insertion.
$msrp = str_replace('$', '', $_POST["vehicleMSRP"]);

$db->enableExceptions(true);
try {
    //Attempt insert into database
    $db->exec('INSERT INTO vehicle (model_name, model_year, brand_name, color, msrp)' 
                . 'VALUES("' . $model . '", ' . $year . ', "' . $brand . '", "' 
                . $color . '", ' . $msrp . ')');
    echo "Successfully inserted into database, assigned vehicle ID #: " . $db->lastinsertRowID();
    $db->close();
    exit();
} catch (Exception $e) {
    if (str_contains($e->getMessage(), "FOREIGN KEY constraint failed")) {
        echo "This dealership ID does not refer to an extant dealership.\n";
    }
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}
