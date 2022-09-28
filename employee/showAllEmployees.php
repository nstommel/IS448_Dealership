<?php
session_start();
$db = new SQLite3("../dealership.db");
$db->exec("PRAGMA foreign_keys = ON");
$db->enableExceptions(true);
//echo var_dump($_POST);
$orderby = $_POST["orderByEmployee"];

try {
    $querystr = "SELECT * FROM employee ORDER BY " . $orderby;
    $result = $db->query($querystr);
    if (!$result->fetchArray()) {
        header("HTTP/1.0 500 Internal Server Error");
        echo "No records found.";
        $db->close();
        die();
    } else {
        $result->reset();
        echo "<div class='card mt-4'>
                <div class='card-header h5'>All Employees</div>
                    <div class='card-body'>                                                                                    
                        <table class='table table-striped'>
                            <tr>
                            <th>Employee ID</th>
                            <th>Dealership ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Password</th>
                            </tr>";
        while ($row = $result->fetchArray()) {
            echo            "<tr>
                                <td>" . htmlspecialchars($row["employee_id"]) . "</td>
                                <td>" . htmlspecialchars($row["dealership_id"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_fname"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_lname"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_email"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_phone"]) . "</td>
                                <td>" . htmlspecialchars($row["employee_role"]) . "</td>";
            //Only show the password of the logged-in user.
            if($_SESSION["employeeID"] === $row["employee_id"]) {
                echo "<td>" . htmlspecialchars($row["employee_password"]) . "</td>";
            } else {
                echo "<td>**********</td>";
            }     
                        echo "</tr>";
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

