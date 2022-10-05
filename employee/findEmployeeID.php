<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$id = $_POST["employeeID"];
$querystr = "SELECT * FROM employee WHERE employee_id = " . $id;
$db->enableExceptions(true);
try {
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records match this employee id.";
        $db->close();
        die();
    } else {
        $result->reset();
        $row = $result->fetchArray();
        echo "<div class='card mt-4'>
                <div class='card-header h5'>Employee Information:</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                                <th>Employee ID</th>
                                <td>" . htmlspecialchars($row["employee_id"]) . "</td>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <td>" . htmlspecialchars($row["employee_fname"]) . "</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>" . htmlspecialchars($row["employee_lname"]) . "</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>" . htmlspecialchars($row["employee_email"]) . "</td>
                            <tr>
                                <th>Phone</th>
                                <td>" . htmlspecialchars($row["employee_phone"]) . "</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>" .htmlspecialchars($row["employee_role"]) . "</td>
                            </tr>
                            <tr>
                                <th>Password</th>";
                            if($_SESSION["employeeID"] === $row["employee_id"]) {
                                echo "<td>" . htmlspecialchars($row["employee_password"]) . "</td>";
                            } else {
                                echo "<td>**********</td>";
                            }                            
echo                    "</table>
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