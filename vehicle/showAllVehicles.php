<?php

$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
//echo var_dump($_POST);
$orderby = $_POST["orderByVehicle"];

try {
    $querystr = "SELECT * FROM vehicle ORDER BY " . $orderby;
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records found.";
        $db->close();
        die();
    } else {
        $result->reset();
        echo "<div class='card mt-4'>
                <div class='card-header h5'>All Vehicles</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>Vehicle ID #</th>
                                <th>Model Name</th>
                                <th>Model Year</th>
                                <th>Brand Name</th>
                                <th>Color</th>
                                <th>MSRP</th>
                            </tr>";
        while ($row = $result->fetchArray()) {
            echo            "<tr>
                                <td>" . $row["vin"] . "</td>
                                <td>" . htmlspecialchars($row["model_name"]) . "</td>
                                <td>" . htmlspecialchars($row["model_year"]) . "</td>
                                <td>" . htmlspecialchars($row["brand_name"]) . "</td>
                                <td>" . htmlspecialchars($row["color"]) . "</td>";
                                //Format dollar amount for display from decimal number in database.
            echo                "<td>\$" . number_format($row["msrp"], 2, ".", ",") . "</td>
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

