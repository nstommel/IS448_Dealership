<?php
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$id = $_POST["dealershipID"];
$db->enableExceptions(true);
try {
    $stmt = $db->prepare('SELECT * FROM dealership WHERE dealership_id = :id');
    $stmt->bindValue(':id', intval($id), SQLITE3_INTEGER);
    $result = $stmt->execute();
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this dealership id number.";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        // dealership_id, dealership_name, dealership_city, dealership_state, dealership_phone
        echo "<div class='card mt-4'>
                <div class='card-header h5'>Dealership Information:</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>Dealership ID</th>
                                <td>" . htmlspecialchars($row["dealership_id"]) . "</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>" . htmlspecialchars($row["dealership_name"]) . "</td>
                            <tr>
                            <tr>
                                <th>City</th>
                                <td>" . htmlspecialchars($row["dealership_city"]) . "</td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>" . htmlspecialchars($row["dealership_state"]) . "</td>
                            </tr>
                                <th>Phone</th>
                                <td>" . htmlspecialchars($row["dealership_phone"]) . "</td>
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