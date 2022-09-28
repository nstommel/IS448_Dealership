<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$id = $_POST["customerID"];

$db->enableExceptions(true);
try {
    $result = $db->query('SELECT * FROM customer WHERE customer_id = "' . $id . '"');
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this customer ID, cannot delete.";
        $db->close();
        die();
    } else {
        $db->exec('DELETE FROM customer WHERE customer_id = ' . $id); 
        echo "Successfully deleted customer record in database!";
        $db->close();
        exit();
    }
} catch (Exception $e) {
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Unable to delete.\n";
    if (str_contains($e->getMessage(), "FOREIGN KEY constraint failed")) {
        echo "Customer has associated sales or services, deleting aborted.\n"
                . "Please remove these records before attempting deletion.";
    } else {
        echo "A different database error occurred: " . $e->getMessage();
    }
    $db->close();
    die();
}