<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$id = $_POST["customerID"];
$querystr = "SELECT * FROM customer WHERE customer_id = " . $id;
$db->enableExceptions(true);
try {
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this customer id.";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        echo "<div class='card mt-4'>
                <div class='card-header h5'>Customer Information</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>Customer ID</th>
                                <td>" . htmlspecialchars($row["customer_id"]) . "</td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td>" . htmlspecialchars($row["customer_fname"]) . "</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>" . htmlspecialchars($row["customer_lname"]) . "</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>" . htmlspecialchars($row["customer_email"]) . "</td>
                            <tr>
                                <th>Phone</th>
                                <td>" . htmlspecialchars($row["customer_phone"]) . "</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>";
    }
} catch (Exception $e) {
    header("HTTP/1.0 500 Internal Server Error");
    echo "Unable to retreive record.\n";
    echo "A different database error occurred: " . $e->getMessage();
    $db->close();
    die();
}
