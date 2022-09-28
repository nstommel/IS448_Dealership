<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
//echo var_dump($_POST);
$orderby = $_POST["orderByCustomer"];

try {
    $querystr = "SELECT * FROM customer ORDER BY " . $orderby;
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records found.";
        $db->close();
        die();
    } else {
        $result->reset();
        echo "<div class='card mt-4'>
                <div class='card-header h5'>All Customers</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                            <th>Customer ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            </tr>";
        while ($row = $result->fetchArray()) {
            echo            "<tr>
                                <td>" . htmlspecialchars($row["customer_id"]) . "</td>
                                <td>" . htmlspecialchars($row["customer_fname"]) . "</td>
                                <td>" . htmlspecialchars($row["customer_lname"]) . "</td>
                                <td>" . htmlspecialchars($row["customer_email"]) . "</td>
                                <td>" . htmlspecialchars($row["customer_phone"]) . "</td>
                            </tr>";
        }
        echo            "</table>
                    </div>
                </div>
            </div>";
        $db->close();
        exit();
    }
} catch (Exception $e) {
    //Set error header appropriately
    header("HTTP/1.0 500 Internal Server Error");        
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}

