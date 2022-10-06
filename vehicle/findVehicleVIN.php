<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$vin = $_POST["vin"];
$db->enableExceptions(true);
try {
    $stmt = $db->prepare('SELECT * FROM vehicle WHERE vin = :vin');
    $stmt->bindValue(':vin', intval($vin), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this vehicle id number.";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // vin, model_name, model_year, brand_name, color, msrp
        echo "<div class='card mt-4'>
                <div class='card-header h5'>Vehicle Information:</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>VIN</th>
                                <td>" . htmlspecialchars($row["vin"]) . "</td>
                            </tr>
                            <tr>
                                <th>Brand Name</th>
                                <td>" . htmlspecialchars($row["brand_name"]) . "</td>
                            <tr>
                            <tr>
                                <th>Model Name</th>
                                <td>" . htmlspecialchars($row["model_name"]) . "</td>
                            </tr>
                            <tr>
                                <th>Model Year</th>
                                <td>" . htmlspecialchars($row["model_year"]) . "</td>
                            </tr>
                                <th>Color</th>
                                <td>" . htmlspecialchars($row["color"]) . "</td>
                            </tr>
                            <tr>
                                <th>MSRP</th>
                                <td>\$" . number_format($row["msrp"], 2, ".", ",") . "</td>
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