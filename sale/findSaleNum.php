<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$snum = $_POST["saleNum"];
$db->enableExceptions(true);
try {
    $stmt = $db->prepare('SELECT * FROM sale WHERE sale_num = :snum');
    $stmt->bindValue(':snum', intval($snum), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this sale order number.";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // sale_num, vin, employee_id, customer_id, dealership_id, sale_date, sale_cost
        echo "<div class='card mt-4'>
                <div class='card-header h5'>Sale Order Information:</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>Sale Number</th>
                                <td>" . htmlspecialchars($row["sale_num"]) . "</td>
                            </tr>
                            <tr>
                                <th>VIN</th>
                                <td>" . htmlspecialchars($row["vin"]) . "</td>
                            <tr>
                            <tr>
                                <th>Employe ID</th>
                                <td>" . htmlspecialchars($row["employee_id"]) . "</td>
                            </tr>
                            <tr>
                                <th>Customer ID</th>
                                <td>" . htmlspecialchars($row["customer_id"]) . "</td>
                            </tr>
                                <th>Dealership ID</th>
                                <td>" . htmlspecialchars($row["dealership_id"]) . "</td>
                            </tr>
                            </tr>
                                <th>Date</th>
                                <td>" . htmlspecialchars($row["sale_date"]) . "</td>
                            </tr>
                            <tr>
                                <th>Cost</th>
                                <td>\$" . number_format($row["sale_cost"], 2, ".", ",") . "</td>
                            <tr>
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
