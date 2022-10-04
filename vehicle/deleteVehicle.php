<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$vin = $_POST["vin"];

$db->enableExceptions(true);
try {
    $stmt = $db->prepare('SELECT * FROM vehicle WHERE vin = :vin');
    $stmt->bindValue(':vin', intval($vin), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this vehicle ID, cannot delete.";
        $db->close();
        die();
    } else {
        $stmt = $db->prepare('DELETE FROM vehicle WHERE vin = :vin');
        $stmt->bindValue(':vin', intval($vin), SQLITE3_INTEGER);
        $result = $stmt->execute();
        echo "Successfully deleted vehicle record #" . $vin . " in database!";
        $db->close();
        exit();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Unable to delete.\n";
    if (str_contains($e->getMessage(), "FOREIGN KEY constraint failed")) {
        echo "Vehicle has associated sales or services, deleting aborted.\n"
                . "Please remove these records before attempting deletion.";
    } else {
        echo "A different database error occurred: " . $e->getMessage();
    }
    $db->close();
    die();
}