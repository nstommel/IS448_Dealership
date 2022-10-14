<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
//echo var_dump($_POST);
$orderby = $_POST["orderBySale"];

try {
    $querystr = "SELECT * FROM sale ORDER BY " . $orderby;
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        echo "<h3 class='mt-4 ml-4'>No records found.</h3>";
        $db->close();
    } else {
        $result->reset();
        // sale_num, vin, employee_id, customer_id, sale_date, sale_cost
        // Also show dealership id from vehicle table (the car's origin / sale location)
        echo "<div class='card mt-4'>
                <div class='card-header h5'>All Sales</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                            <th>Sale #</th>
                            <th>VIN</th>
                            <th>Employee ID</th>
                            <th>Customer ID</th>
                            <th>Dealership ID</th>
                            <th>Sale Date</th>
                            <th>Sale Cost</th>
                            </tr>";
        while ($row = $result->fetchArray()) {
            echo            "<tr>
                                <td>" . htmlspecialchars($row["sale_num"]) . "</td>
                                <td>" . htmlspecialchars($row["vin"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_id"]) . "</td>
                                <td>" . htmlspecialchars($row["customer_id"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_id"]) . "</td>
                                <td>" . htmlspecialchars($row["sale_date"]) . "</td>
                                <td>\$" . number_format($row["sale_cost"], 2, ".", ",") . "</td>
                            </tr>";
        }
        echo            "</table>
                    </div>
                </div>
            </div>";
        $db->close();
    }
} catch (Exception $e) {
    // Set error header appropriately
    header("HTTP/1.0 500 Internal Server Error");        
    echo "Database error: " . $e->getMessage();
    $db->close();
    die();
}