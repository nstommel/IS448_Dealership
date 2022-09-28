<?php

$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

$id = $_POST["customerID"];
$fname = trim($_POST["customerFname"]);
$lname = trim($_POST["customerLname"]);
$email = trim($_POST["customerEmail"]);
$phone = trim($_POST["customerPhone"]);

$db->enableExceptions(true);
try {
    $result = $db->query('SELECT * FROM customer WHERE customer_id = "' . $id . '"');
    if(!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this customer ID, cannot update.";
        $db->close();
        die();
    } else {
        $result->reset();
        $db->exec('UPDATE customer SET customer_fname = "' . $fname .'", customer_lname = "' . 
                $lname . '", customer_email = LOWER("' . $email . '"), customer_phone = "' . $phone . 
                '" WHERE customer_id = "' . $id . '"'); 
        echo "Successfully updated record in database!";
        $db->close();
        exit();
    }
} catch (Exception $e) {
    if(str_contains($e->getMessage(), "UNIQUE constraint failed")) {
        echo "This email address is already in use by another customer.\n"
            . "Please enter a different email address.\n";
    }
    //Set error header for HTTP error appropriately
    header("HTTP/1.0 500 Internal Server Error");
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}
