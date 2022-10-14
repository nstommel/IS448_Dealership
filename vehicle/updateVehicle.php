<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$vin = intval($_POST["vehicleVIN"]);
$model = trim($_POST["vehicleModel"]);
$year = intval($_POST["vehicleYear"]);
$brand = trim($_POST["vehicleBrand"]);
$color = trim($_POST["vehicleColor"]);
$msrp = floatval(str_replace('$', '', trim($_POST["vehicleMSRP"])));

$db->enableExceptions(true);
try {
    $stmt = $db->prepare('SELECT * FROM vehicle WHERE vin = :vin');
    $stmt->bindValue(':vin', $vin, SQLITE3_INTEGER);
    $result = $stmt->execute();
    
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this vehicle ID #, cannot update.";
        $db->close();
        die();
    } else {
        $result->reset();
        // vin, model_name, model_year, brand_name, color, msrp
        $queryStr = 'UPDATE vehicle SET model_name = :model, model_year = :year, ' . 
                    'brand_name = :brand, color = :color, msrp = :msrp WHERE vin = :vin';
        $stmt = $db->prepare($queryStr);
        $stmt->bindValue(':model', $model, SQLITE3_TEXT);
        $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
        $stmt->bindValue(':brand', $brand, SQLITE3_TEXT);
        $stmt->bindValue(':color', $color, SQLITE3_TEXT);
        $stmt->bindValue(':msrp', $msrp, SQLITE3_FLOAT);
        $stmt->bindValue(':vin', $vin, SQLITE3_INTEGER);
        $stmt->execute();
        echo "Successfully updated record in database!";
        $db->close();
        exit();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}


