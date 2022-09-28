<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");

//$customer_fname = "John";
//$customer_lname = "Smith";
//$customer_email = "jsmith@gmail.com";
//$customer_phone = "443-492-7045";
//customer_fname, customer_lname, customer_email, customer_phone
$customer_fname = trim($_POST["customerFname"]);
$customer_lname = trim($_POST["customerLname"]);
$customer_email = trim($_POST["customerEmail"]);
$customer_phone = trim($_POST["customerPhone"]);

$db->enableExceptions(true);
try {
    //Attempt insert into database
    $db->exec('INSERT INTO customer (customer_fname, customer_lname, customer_email, ' . 
                'customer_phone) VALUES("' . $customer_fname . '", "' . $customer_lname . 
                '", LOWER("' . $customer_email . '"), "' . $customer_phone . '")');
    echo "Successfully inserted into database, assigned customer ID #: " . $db->lastinsertRowID();
    $db->close();
    exit();
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

