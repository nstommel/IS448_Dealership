<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
//echo var_dump($_POST);
$orderby = $_POST["orderByDealership"];

try {
    $querystr = "SELECT * FROM dealership ORDER BY " . $orderby;
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records found.";
        $db->close();
        die();
    } else {
        $result->reset();
        //dealership_id, dealership_name, dealership_city, dealership_state, dealership_phone
        echo "<div class='card mt-4'>
                <div class='card-header h5'>All Dealerships</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>Dealership ID</th>
                                <th>Dealership Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Phone</th>
                            </tr>";
        while ($row = $result->fetchArray()) {
            echo            "<tr>
                                <td>" . htmlspecialchars($row["dealership_id"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_name"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_city"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_state"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_phone"]) . "</td>
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
