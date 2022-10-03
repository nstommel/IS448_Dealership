<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
//echo var_dump($_POST);
$orderby = $_POST["orderByService"];

try {
    $querystr = "SELECT * FROM service ORDER BY " . $orderby;
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records found.";
        $db->close();
        die();
    } else {
        $result->reset();
        // service_num, vin, employee_id, customer_id, dealership_id, service_date, service_cost
        echo "<div class='card mt-4'>
                <div class='card-header h5'>All Services</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                            <th>Service #</th>
                            <th>VIN</th>
                            <th>Employee ID</th>
                            <th>Customer ID</th>
                            <th>Dealership ID</th>
                            <th>Service Date</th>
                            <th>Service Cost</th>
                            </tr>";
        while ($row = $result->fetchArray()) {
            echo            "<tr>
                                <td>" . htmlspecialchars($row["service_num"]) . "</td>
                                <td>" . htmlspecialchars($row["vin"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_id"]) . "</td>
                                <td>" . htmlspecialchars($row["customer_id"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_id"]) . "</td>
                                <td>" . htmlspecialchars($row["service_date"]) . "</td>
                                <td>\$" . number_format($row["service_cost"], 2, ".", ",") . "</td>
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