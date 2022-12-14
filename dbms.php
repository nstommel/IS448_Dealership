<?php
session_start();
if(empty($_SESSION['employeeID'])){
    //Redirect user if they attempt to access this page without logging in.
    echo "Unauthorized user detected, please login. Redirecting in 3 seconds.";
    header("refresh:3; url=loginPortal.php" );    
} else {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--Include Bootstrap 4 CSS and JS with jQuery Ajax, use offline files obtained with curl-->
        <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" />-->
        <link rel="stylesheet" href="bootstrap-jquery/bootstrap.css" />
        <!--<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>-->
        <script src="bootstrap-jquery/jquery.js"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>-->
        <script src="bootstrap-jquery/bootstrap.bundle.js"></script>
        <title>Quality Cars DBMS</title>
        <link rel="stylesheet" href="dbms.css" />
        <script src="customer/customer.js"></script>
        <script src="employee/employee.js"></script>
        <script src="vehicle/vehicle.js"></script>
        <script src="dealership/dealership.js"></script>
        <script src="sale/sale.js"></script>
        <script src="service/service.js"></script>
        <style>            
            /*Additional test styles go here*/
        </style>
    </head>
        <body>
            <nav class="navbar bg-dark navbar-dark">                
                <h3 class="navbar-text text-white" style="padding: 0px;">Quality Cars Employee DBMS</h3>
                <a class="btn btn-light ml-auto mr-2" href="login/logout.php">Logout</a>
            </nav>
            <div class="container-fluid float-left">        
                <div class="row my-4 mr-2">
                    <div class="container col-2">
                        <div class="nav flex-column nav-pills" id="pillsTabs">
                            <a class="nav-link active" id="customerPillTab" data-toggle="pill" href="#customerPill">Customer</a>
                            <a class="nav-link" id="employeePillTab" data-toggle="pill" href="#employeePill">Employee</a>
                            <a class="nav-link" id="vehiclePillTab" data-toggle="pill" href="#vehiclePill">Vehicle</a>
                            <a class="nav-link" id="dealershipPillTab" data-toggle="pill" href="#dealershipPill">Dealership</a>
                            <a class="nav-link" id="salePillTab" data-toggle="pill" href="#salePill">Sale</a>
                            <a class="nav-link" id="servicePillTab" data-toggle="pill" href="#servicePill">Service</a>
                        </div>
                    </div>
                    <div class="tab-content col-10" id="pillsTabContent">
                        <div class="tab-pane fade show active " id="customerPill">
                            <ul class="nav nav-tabs" id="customerTabs">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#customerTab1">Insert</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#customerTab2">Update</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#customerTab3">Delete</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#customerTab4">Find</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#customerTab5">Show All</a></li>
                            </ul>
                            <div class="tab-content p-4 bg-light border" id="customerTabPanels">
                                <div class="tab-pane fade show active" id="customerTab1">                                    
                                    <div class="card">
                                        <div class="card-header h5">Insert a customer:</div>
                                        <form class="card-body was-validated" action="javascript:void(0)" method="post" id="insertCustomerForm" onsubmit="insertCustomer()">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertCustomerFname">Customer First Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter first name" id="insertCustomerFname" name="customerFname" required />
                                                <div class="valid-feedback">First name looks good.</div>
                                                <div class="invalid-feedback">Please enter the customer's first name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertCustomerLname">Customer Last Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter last name" id="insertCustomerLname" name="customerLname" required />
                                                <div class="valid-feedback">Last name looks good.</div>
                                                <div class="invalid-feedback">Please enter the customer's last name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertCustomerEmail">Customer Email:</label>
                                                <input type="email" class="form-control" placeholder="Enter email" id="insertCustomerEmail" name="customerEmail" required />
                                                <div class="valid-feedback">Email looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid email address.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertCustomerPhone">Customer Phone:</label>
                                                <input type="tel" placeholder="Enter phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" name="customerPhone" id="insertCustomerPhone" required />
                                                <div class="valid-feedback">Phone number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid phone number in the format XXX-XXX-XXXX.</div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Insert Customer">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="customerTab2">                                    
                                    <div class="card">
                                        <div class="card-header h5">Update Customer</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="updateFillCustomerForm" onsubmit="updateFillCustomer()">                                            
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateFillCustomerID">Fill in other values in the form below by entering a customer ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateFillCustomerID" name="customerID" required />
                                                    <div class="valid-feedback">Customer ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Fill Record Details" />
                                                </div>
                                            </form>
                                            <label class="font-weight-bold" for="updateCustomerForm">Fill in this form to update a customer record:</label>
                                            <form class="was-validated" action="javascript:void(0)" id="updateCustomerForm" onsubmit="updateCustomer()">                                        
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateCustomerID">Customer ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateCustomerID" name="customerID" required />
                                                    <div class="valid-feedback">Customer ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateCustomerFname">First Name:</label>
                                                    <input class="form-control" type="text" placeholder="Enter first name" id="updateCustomerFname" name="customerFname" required />
                                                    <div class="valid-feedback">First name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the customer's first name.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateCustomerLname">Last Name:</label>
                                                    <input class="form-control" type="text" placeholder="Enter last name" id="updateCustomerLname" name="customerLname" required />
                                                    <div class="valid-feedback">Last name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the customer's last name.</div>
                                                </div>
                                                <div class="form-group">                                                                                                
                                                    <label class="font-weight-bold" for="updateCustomerEmail">Customer Email:</label>
                                                    <input type="email" class="form-control" placeholder="Enter email" id="updateCustomerEmail" name="customerEmail" required />
                                                    <div class="valid-feedback">Email looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateCustomerPhone">Phone:</label>
                                                    <input type="tel" placeholder="Enter phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" id="updateCustomerPhone" name="customerPhone" required />
                                                    <div class="valid-feedback">Phone number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid phone number in the format XXX-XXX-XXXX.</div>
                                                </div>                                            
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Update Customer">
                                                </div>
                                            </form>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="tab-pane fade" id="customerTab3">                                    
                                    <div class="card">
                                        <div class="card-header h5">Delete a customer:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="deleteCustomerForm" onsubmit="deleteCustomer()">                                            
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="deleteCustomerID">Delete a customer by entering a customer ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="deleteCustomerID" name="customerID" required />
                                                    <div class="valid-feedback">Customer ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Delete Customer" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="customerTab4">
                                    <div class="card">
                                        <div class="card-header h5">Find a customer:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="findCustomerIDForm" onsubmit="findCustomerID()">                                            
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="findCustomerIDInput">Find a customer by entering a customer ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="findCustomerIDInput" name="customerID" required />
                                                    <div class="valid-feedback">Customer ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Find customer by ID" />
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                    <div id="findCustomerTable"></div>
                                </div>
                                <div class="tab-pane fade" id="customerTab5">                                    
                                    <form class="form-inline" id="customerOrderBy" action="javascript:void(0)" onsubmit="showAllCustomers()">
                                        <div class="form-group mr-2">
                                            <label for="orderByCustomer">Select order to display results:</label>
                                        </div>
                                        <div class="form-group mr-2">
                                            <select class="form-control" name="orderByCustomer" id="orderByCustomer">
                                                <option value="customer_id asc" selected>Customer ID Ascending</option>
                                                <option value="customer_id desc">Customer ID Descending</option>
                                                <option value="customer_lname collate nocase asc, customer_fname collate nocase asc">Customer Name Ascending</option>
                                                <option value="customer_lname collate nocase desc, customer_fname collate nocase desc">Customer Name Descending</option>
                                                <option value="customer_email asc">Customer Email Ascending</option>
                                                <option value="customer_email desc">Customer Email Descending</option>
                                                <option value="customer_phone asc">Customer Phone Ascending</option>
                                                <option value="customer_phone desc">Customer Phone Descending</option>
                                            </select>
                                        </div>
                                        <div class ="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Refresh Display" />
                                        </div>
                                    </form>                                    
                                    <div id="allCustomersTable"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="employeePill">
                            <ul class="nav nav-tabs" id="employeeTabs">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#employeeTab1">Insert</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#employeeTab2">Update</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#employeeTab3">Delete</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#employeeTab4">Find</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#employeeTab5">Show All</a></li>
                            </ul>
                            <div class="tab-content p-4 bg-light border" id="employeeTabPanels">
                                <div class="tab-pane fade show active" id="employeeTab1">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager to insert an employee!</div></div>";                                            
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Insert an employee:</div>
                                        <form class="card-body was-validated" action="javascript:void(0)" method="post" id="insertEmployeeForm" onsubmit="insertEmployee()">                                        
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeeDealershipID">Dealership ID #</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="insertEmployeeDealershipID" name="dealershipID" required />
                                                <div class="valid-feedback">Dealership ID looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer dealership ID.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeeFname">Employee First Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter first name" id="insertEmployeeFname" name="employeeFname" required />
                                                <div class="valid-feedback">First name looks good.</div>
                                                <div class="invalid-feedback">Please enter the employee's first name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeeLname">Employee Last Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter last name" id="insertEmployeeLname" name="employeeLname" required />
                                                <div class="valid-feedback">Last name looks good.</div>
                                                <div class="invalid-feedback">Please enter the employee's last name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeeEmail">Employee Email:</label>
                                                <input type="email" class="form-control" placeholder="Enter email" id="insertEmployeeEmail" name="employeeEmail" required />
                                                <div class="valid-feedback">Email looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid email address.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeePhone">Employee Phone:</label>
                                                <input type="tel" placeholder="Enter phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" name="employeePhone" id="insertEmployeePhone" required />
                                                <div class="valid-feedback">Phone number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid phone number in the format XXX-XXX-XXXX.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeeRoleRadio">Employee Role:</label>
                                                <div id="insertEmployeeRoleRadio">                                                    
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" checked="checked" value="Manager" id="insertEmployeeRoleManager" name="employeeRole" />
                                                        <label for="insertEmployeeRoleManager" class="form-check-label text-dark">Manager</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" value="Salesperson" id="insertEmployeeRoleSalesperson" name="employeeRole" />
                                                        <label for="insertEmployeeRoleSalesperson" class="form-check-label text-dark">Salesperson</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input type="radio" class="form-check-input" value="Mechanic" id="insertEmployeeRoleMechanic" name="employeeRole" />
                                                        <label for="insertEmployeeRoleMechanic" class="form-check-label text-dark">Mechanic</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertEmployeePassword">Password:</label>
                                                <input class="form-control" type="password" placeholder="Enter password" id="insertEmployeepassword" name="employeePassword" required />
                                                <div class="valid-feedback">Password looks good.</div>
                                                <div class="invalid-feedback">Please enter the new employee's password.</div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Insert Employee">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="employeeTab2">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager to update an employee's details!<br />You can, however, update just your password.</div></div>";                                            
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Update Employee</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="updateFillEmployeeForm" onsubmit="updateFillEmployee()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateFillEmployeeID">Fill in other values in the form below by entering an employee ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateFillEmployeeID" name="employeeID" required />
                                                    <div class="valid-feedback">Employee ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Fill Record Details" />
                                                </div>
                                            </form>
                                            <label class="font-weight-bold" for="updateEmployeeForm">Fill in this form to update an employee record:</label>
                                            <!--<form class="was-validated" method="post" action="employee/updateEmployee.php" id="updateEmployeeForm">-->
                                            <form class="was-validated" action="javascript:void(0)" id="updateEmployeeForm" onsubmit="updateEmployee()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateEmployeeID">Employee ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateEmployeeID" name="employeeID" required />
                                                    <div class="valid-feedback">Employee ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateEmployeeDealershipID">Dealership ID #</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateEmployeeDealershipID" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer dealership ID.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateEmployeeFname">First Name:</label>
                                                    <input class="form-control" type="text" placeholder="Enter first name" id="updateEmployeeFname" name="employeeFname" required />
                                                    <div class="valid-feedback">First name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the employee's first name.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateEmployeeLname">Last Name:</label>
                                                    <input class="form-control" type="text" placeholder="Enter last name" id="updateEmployeeLname" name="employeeLname" required />
                                                    <div class="valid-feedback">Last name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the employee's last name.</div>
                                                </div>
                                                <div class="form-group">                                                                                                
                                                    <label class="font-weight-bold" for="updateEmployeeEmail">Employee Email:</label>
                                                    <input type="email" class="form-control" placeholder="Enter email" id="updateEmployeeEmail" name="employeeEmail" required />
                                                    <div class="valid-feedback">Email looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateEmployeePhone">Employee Phone:</label>
                                                    <input type="tel" placeholder="Enter phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" id="updateEmployeePhone" name="employeePhone" required />
                                                    <div class="valid-feedback">Phone number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid phone number in the format XXX-XXX-XXXX.</div>
                                                </div>                                                                                            
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateEmployeeRoleRadio">Employee Role:</label>
                                                    <div id="updateEmployeeRoleRadio">                                                    
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input" checked="checked" value="Manager" id="updateEmployeeRoleManager" name="employeeRole" />
                                                            <label for="updateEmployeeRoleManager" class="form-check-label text-dark">Manager</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input" value="Salesperson" id="updateEmployeeRoleSalesperson" name="employeeRole" />
                                                            <label for="updateEmployeeRoleSalesperson" class="form-check-label text-dark">Salesperson</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input type="radio" class="form-check-input" value="Mechanic" id="updateEmployeeRoleMechanic" name="employeeRole" />
                                                            <label for="updateEmployeeRoleMechanic" class="form-check-label text-dark">Mechanic</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Update Employee">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card mt-4">
                                        <div class="card-header h5">Update Your Password</div>
                                        <div class="card-body">
                                            <?php
                                                echo "<div class='font-weight-bold'>You are employee #" . $_SESSION["employeeID"] . ". Update your password below:</div>";
                                            ?>
                                            <form class="form-inline mt-2" method="post" action="javascript:void(0)" id="updatePasswordForm" onsubmit="updatePassword()">
                                                <!--<form class="form-inline mt-2" method="post" action="employee/updatePassword.php" id="updatePasswordForm">-->
                                                <div class="form-group mr-2">
                                                    <label for="updatePasswordInput">Password:</label>
                                                </div>
                                                <div class="form-group mr-2">
                                                    <input class="form-control" type="password" placeholder="Enter new password:" id="updatePasswordInput" name="password" required />                                                        
                                                </div>
                                                <div class ="form-group">
                                                    <input type="submit" class="btn btn-primary" name="submit" value="Change Password" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="employeeTab3">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager to delete an employee!</div></div>";                                            
                                        }
                                    ?>
                                    <div class="card">                                       
                                        <div class="card-header h5">Delete an employee:</div>                                        
                                        <div class="card-body">                                            
                                            <!--<form class="was-validated" method="post" action="employee/deleteEmployee.php" id="deleteEmployeeForm">-->                                                
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="deleteEmployeeForm" onsubmit="deleteEmployee()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="deleteEmployeeID">Delete a employee by entering an employee ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="deleteEmployeeID" name="employeeID" required />
                                                    <div class="valid-feedback">Employee ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Delete Employee" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="employeeTab4">                                                                        
                                    <div class="card">
                                        <div class="card-header h5">Find an employee:</div>
                                        <div class="card-body">
                                            <!--<form class="was-validated" method="post" action="employee/findEmployeeID.php" id="findEmployeeIDForm">-->
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="findEmployeeIDForm" onsubmit="findEmployeeID()">                                            
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="findEmployeeIDInput">Find an employee by entering an employee ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="findEmployeeIDInput" name="employeeID" required />
                                                    <div class="valid-feedback">Employee ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Find employee by ID" />
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                    <div id="findEmployeeTable"></div>
                                </div>
                                <div class="tab-pane fade" id="employeeTab5">
                                    <form class="form-inline" id="employeeOrderBy" action="javascript:void(0)" onsubmit="showAllEmployees()">                                    
                                        <div class="form-group mr-2">
                                            <label for="orderByEmployee">Select order to display results:</label>
                                        </div>
                                        <div class="form-group mr-2">
                                            <select class="form-control" name="orderByEmployee" id="orderByEmployee">
                                                <option value="employee_id asc" selected>Employee ID Ascending</option>
                                                <option value="employee_id desc">Employee ID Descending</option>
                                                <option value="dealership_id asc">Dealership ID Ascending</option>
                                                <option value="dealership_id desc">Dealership ID Descending</option>                                                
                                                <option value="employee_lname collate nocase asc, employee_fname collate nocase asc">Employee Name Ascending</option>
                                                <option value="employee_lname collate nocase desc, employee_fname collate nocase desc">Employee Name Descending</option>
                                                <option value="employee_email asc">Employee Email Ascending</option>
                                                <option value="employee_email desc">Employee Email Descending</option>
                                                <option value="employee_phone asc">Employee Phone Ascending</option>
                                                <option value="employee_phone desc">Employee Phone Descending</option>
                                                <option value="employee_role asc">Employee Role Ascending</option>
                                                <option value="employee_role desc">Employee Role Descending</option>
                                            </select>
                                        </div>
                                        <div class ="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Refresh Display" />
                                        </div>
                                    </form>                                    
                                    <div id="allEmployeesTable"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="vehiclePill">
                            <ul class="nav nav-tabs" id="vehicleTabs">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#vehicleTab1">Insert</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#vehicleTab2">Update</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#vehicleTab3">Delete</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#vehicleTab4">Find</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#vehicleTab5">Show All</a></li>
                            </ul>
                            <div class="tab-content p-4 bg-light border" id="vehicleTabPanels">
                                <div class="tab-pane fade show active" id="vehicleTab1">                                    
                                    <div class="card">
                                        <div class="card-header h5">Insert a vehicle:</div>                                        
                                        <!--<form class="card-body was-validated" action="vehicle/insertVehicle.php" method="post" id="insertVehicleForm">-->
                                        <form class="card-body was-validated" action="javascript:void(0)" method="post" id="insertVehicleForm" onsubmit="insertVehicle()">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertVehicleBrand">Vehicle Brand Name:</label>
                                                <input class="form-control" type="text" placeholder="Enter brand name" id="insertVehicleBrand" name="vehicleBrand" required />
                                                <div class="valid-feedback">Brand name looks good.</div>
                                                <div class="invalid-feedback">Please enter the vehicle's brand name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertVehicleModel">Vehicle Model Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter first name" id="insertVehicleModel" name="vehicleModel" required />
                                                <div class="valid-feedback">Model name looks good.</div>
                                                <div class="invalid-feedback">Please enter the vehicle's model name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertVehicleYear">Vehicle Model Year:</label>
                                                <input class="form-control" type="number" min="1900" max="2099" step="1" placeholder="Enter model year" id="insertVehicleYear" name="vehicleYear" required />
                                                <div class="valid-feedback">Vehicle year looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid model year.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertVehicleColor">Vehicle Color:</label>
                                                <input class="form-control" type="text" placeholder="Enter vehicle color" id="insertVehicleColor" name="vehicleColor" required />
                                                <div class="valid-feedback">Vehicle color looks good.</div>
                                                <div class="invalid-feedback">Please enter the vehicle's color.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertVehicleMSRPGroup">Vehicle MSRP:</label>
                                                <div class="input-group" id="insertVehicleMSRPGroup">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input class="form-control rounded-right" type="text" pattern="^\d+(\.\d{2})?$" placeholder="Enter MSRP" id="insertVehicleMSRP" name="vehicleMSRP" required />
                                                    <div class="valid-feedback">Vehicle MSRP looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid MSRP in dollars.</div>
                                                </div>
                                            </div>
                                            <div class ="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" name="insert" value="Insert Vehicle" />
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vehicleTab2">
                                    <div class="card">
                                        <div class="card-header h5">Update a vehicle:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="updateFillVehicleForm" onsubmit="updateFillVehicle()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateFillVehicleVIN">Fill in other values in the form below by entering a vehicle ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateFillVehicleVIN" name="vehicleVIN" required />
                                                    <div class="valid-feedback">Vehicle ID # looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer vehicle ID #.</div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Fill Record Details" />
                                                </div>
                                            </form>
                                            <label class="font-weight-bold" for="updateVehicleForm">Fill in this form to update a vehicle record:</label>
                                            <form class="was-validated" action="javascript:void(0)" method="post" id="updateVehicleForm" onsubmit="updateVehicle()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateVehicleVIN">Vehicle ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter VIN" id="updateVehicleVIN" name="vehicleVIN" required />
                                                    <div class="valid-feedback">Vehicle ID # looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer vehicle ID #.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateVehicleBrand">Vehicle Brand Name:</label>
                                                    <input class="form-control" type="text" placeholder="Enter brand name" id="updateVehicleBrand" name="vehicleBrand" required />
                                                    <div class="valid-feedback">Brand name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the vehicle's brand name.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateVehicleModel">Vehicle Model Name:</label>
                                                    <input type="text" class="form-control" placeholder="Enter first name" id="updateVehicleModel" name="vehicleModel" required />
                                                    <div class="valid-feedback">Model name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the vehicle's model name.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateVehicleYear">Vehicle Model Year:</label>
                                                    <input class="form-control" type="number" min="1900" max="2099" step="1" placeholder="Enter model year" id="updateVehicleYear" name="vehicleYear" required />
                                                    <div class="valid-feedback">Vehicle year looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid model year.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateVehicleColor">Vehicle Color:</label>
                                                    <input class="form-control" type="text" placeholder="Enter vehicle color" id="updateVehicleColor" name="vehicleColor" required />
                                                    <div class="valid-feedback">Phone number looks good.</div>
                                                    <div class="invalid-feedback">Please enter the vehicle's color.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateVehicleMSRPGroup">Vehicle MSRP:</label>
                                                    <div class="input-group" id="updateVehicleMSRPGroup">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input class="form-control rounded-right" type="text" pattern="^\d+(\.\d{2})?$" placeholder="Enter MSRP" id="updateVehicleMSRP" name="vehicleMSRP" required />
                                                        <div class="valid-feedback">Vehicle MSRP looks good.</div>
                                                        <div class="invalid-feedback">Please enter a valid MSRP in dollars.</div>
                                                    </div>
                                                </div>
                                                <div class ="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" name="update" value="Update Vehicle" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vehicleTab3">
                                    <div class="card">                            
                                        <div class="card-header h5">Delete a vehicle:</div>                                        
                                        <div class="card-body">                                            
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="deleteVehicleForm" onsubmit="deleteVehicle()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="deleteVehicleVIN">Delete a vehicle by entering a vehicle ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="deleteVehicleVIN" name="vin" required />
                                                    <div class="valid-feedback">Vehicle ID # looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer vehicle ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Delete Vehicle" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vehicleTab4">
                                    <div class="card">
                                        <div class="card-header h5">Find a vehicle:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="findVehicleVINForm" onsubmit="findVehicleVIN()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="findVehicleVINInput">Find a vehicle by entering a vehicle ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="findVehicleVINInput" name="vin" required />
                                                    <div class="valid-feedback">VIN looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer vehicle ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Find vehicle by VIN" />
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                    <div id="findVehicleTable"></div>
                                </div>
                                <div class="tab-pane fade" id="vehicleTab5">                                                                        
                                    <form class="form-inline" id="vehicleOrderBy" action="javascript:void(0)" onsubmit="showAllVehicles()">                                    
                                        <div class="form-group mr-2">
                                            <label for="orderByVehicle">Select order to display results:</label>
                                        </div>
                                        <div class="form-group mr-2">
                                            <select class="form-control" name="orderByVehicle" id="orderByVehicle">
                                                <option value="vin asc" selected>Vehicle ID Number Ascending</option>
                                                <option value="vin desc">Vehicle ID Number Descending</option>
                                                <option value="brand_name collate nocase asc">Brand Name Ascending</option>
                                                <option value="brand_name collate nocase desc">Brand Name Descending</option>
                                                <option value="model_name collate nocase asc">Model Name Ascending</option>
                                                <option value="model_name collate nocase desc">Model Name Descending</option>
                                                <option value="model_year asc">Model Year Ascending</option>
                                                <option value="model_year desc">Model Year Descending</option>
                                                <option value="color collate nocase asc">Color Ascending</option>
                                                <option value="color collate nocase desc">Color Descending</option>
                                                <option value="msrp asc">MSRP Ascending</option>
                                                <option value="msrp desc">MSRP Descending</option>
                                            </select>
                                        </div>
                                        <div class ="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Refresh Display" />
                                        </div>
                                    </form>                                    
                                    <div id="allVehiclesTable"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="dealershipPill">
                            <ul class="nav nav-tabs" id="dealershipTabs">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#dealershipTab1">Insert</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#dealershipTab2">Update</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#dealershipTab3">Delete</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#dealershipTab4">Find</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#dealershipTab5">Show All</a></li>
                            </ul>
                            <div class="tab-content p-4 bg-light border" id="dealershipTabPanels">
                                <div class="tab-pane fade show active" id="dealershipTab1">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager to insert a dealership!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Insert a dealership:</div>
                                        <!--dealership_name, dealership_city, dealership_state, dealership_phone-->
                                        <form class="card-body was-validated" action="javascript:void(0)" method="post" id="insertDealershipForm" onsubmit="insertDealership()">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertDealershipName">Dealership Name:</label>
                                                <input type="text" class="form-control" placeholder="Enter dealership name" id="insertDealershipName" name="name" required />
                                                <div class="valid-feedback">Dealership name looks good.</div>
                                                <div class="invalid-feedback">Please enter the dealership's name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertDealershipCity">Dealership City:</label>
                                                <input type="text" class="form-control" placeholder="Enter city" id="insertDealershipCity" name="city" required />
                                                <div class="valid-feedback">City name looks good.</div>
                                                <div class="invalid-feedback">Please enter the city name.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertDealershipState">Dealership State:</label>
                                                <!--Use regex pattern to make sure entered state abbreviation is in valid set-->
                                                <input type="text" class="form-control" placeholder="Enter state abbreviation" id="insertDealershipState" name="state" 
                                                       pattern="A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|P[AR]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY]" required />
                                                <div class="valid-feedback">State abbreviation looks good.</div>
                                                <div class="invalid-feedback">Please enter the two-letter all-caps state abbreviation.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertDealershipPhone">Phone:</label>
                                                <input type="tel" placeholder="Enter phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" id="insertDealershipPhone" name="phone" required />
                                                <div class="valid-feedback">Phone number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid phone number in the format XXX-XXX-XXXX.</div>
                                            </div>  
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Insert Dealership">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dealershipTab2">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager to update a dealership!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Update a dealership:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="updateFillDealershipForm" onsubmit="updateFillDealership()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateFillDealershipID">Fill in other values in the form below by entering a dealership ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateFillDealershipID" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID # looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer dealership ID #.</div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Fill Record Details" />
                                                </div>
                                            </form>
                                            <label class="font-weight-bold" for="updateDealershipForm">Fill in this form to update a dealership record:</label>
                                            <form class="was-validated" action="javascript:void(0)" method="post" id="updateDealershipForm" onsubmit="updateDealership()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateDealershipID">Dealership ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="updateDealershipID" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID # looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer dealership ID #.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateDealershipName">Dealership Name:</label>
                                                    <input type="text" class="form-control" placeholder="Enter dealership name" id="updateDealershipName" name="name" required />
                                                    <div class="valid-feedback">Dealership name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the dealership's name.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateDealershipCity">Dealership City:</label>
                                                    <input type="text" class="form-control" placeholder="Enter city" id="updateDealershipCity" name="city" required />
                                                    <div class="valid-feedback">City name looks good.</div>
                                                    <div class="invalid-feedback">Please enter the city name.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateDealershipState">Dealership State:</label>
                                                    <!--Use regex pattern to make sure entered state abbreviation is in valid set-->
                                                    <input type="text" class="form-control" placeholder="Enter state abbreviation" id="updateDealershipState" name="state" 
                                                           pattern="A[KLRZ]|C[AOT]|D[CE]|FL|GA|HI|I[ADLN]|K[SY]|LA|M[ADEINOST]|N[CDEHJMVY]|O[HKR]|P[AR]|RI|S[CD]|T[NX]|UT|V[AIT]|W[AIVY]" required />
                                                    <div class="valid-feedback">State abbreviation looks good.</div>
                                                    <div class="invalid-feedback">Please enter the two-letter all-caps state abbreviation.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateDealershipPhone">Phone:</label>
                                                    <input type="tel" placeholder="Enter phone number" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" class="form-control" id="updateDealershipPhone" name="phone" required />
                                                    <div class="valid-feedback">Phone number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid phone number in the format XXX-XXX-XXXX.</div>
                                                </div>  
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Update Dealership">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dealershipTab3">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager to delete a dealership!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Delete a dealership:</div>                      
                                        <div class="card-body">                                            
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="deleteDealershipForm" onsubmit="deleteDealership()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="deleteDealershipID">Delete a dealership by entering a dealership ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="deleteDealershipID" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID # looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer dealership ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Delete Dealership" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="dealershipTab4">
                                    <div class="card">
                                        <div class="card-header h5">Find a dealership:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="findDealershipIDForm" onsubmit="findDealershipID()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="findDealershipIDInput">Find a dealership by entering a dealership ID #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter ID #" id="findDealershipIDInput" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer dealership ID number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Find dealership by ID" />
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                    <div id="findDealershipTable"></div>
                                </div>
                                <div class="tab-pane fade" id="dealershipTab5">                                    
                                    <form class="form-inline" id="dealershipOrderBy" action="javascript:void(0)" onsubmit="showAllDealerships()">                                    
                                        <div class="form-group mr-2">
                                            <label for="orderByDealership">Select order to display results:</label>
                                        </div>
                                        <div class="form-group mr-2">
                                            <!--dealership_id, dealership_name, dealership_city, dealership_state, dealership_phone-->
                                            <select class="form-control" name="orderByDealership" id="orderByDealership">
                                                <option value="dealership_id asc" selected>Dealership ID # Ascending</option>
                                                <option value="dealership_id desc">Dealership ID # Descending</option>                                                
                                                <option value="dealership_name collate nocase asc">Dealership Name Ascending</option>
                                                <option value="dealership_name collate nocase desc">Dealership Name Descending</option>
                                                <option value="dealership_city collate nocase asc">Dealership City Ascending</option>
                                                <option value="dealership_city collate nocase desc">Dealership City Descending</option>
                                                <option value="dealership_state collate nocase asc">Dealership State Ascending</option>
                                                <option value="dealership_state collate nocase desc">Dealership State Descending</option>
                                                <option value="dealership_phone asc">Dealership Phone Ascending</option>
                                                <option value="dealership_phone desc">Dealership Phone Descending</option>                                                
                                            </select>
                                        </div>
                                        <div class ="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Refresh Display" />
                                        </div>
                                    </form>                                    
                                    <div id="allDealershipsTable"></div>                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="salePill">
                            <ul class="nav nav-tabs" id="saleTabs">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#saleTab1">Insert</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#saleTab2">Update</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#saleTab3">Delete</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#saleTab4">Find</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#saleTab5">Show All</a></li>
                            </ul>
                            <div class="tab-content p-4 bg-light border" id="saleTabPanels">
                                <div class="tab-pane fade show active" id="saleTab1">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager" && $_SESSION["employeeRole"] != "Salesperson") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager or a salesperon to insert a sale order!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Insert a sale order:</div>
                                        <!--vin, employee_id, customer_id, dealership_id, sale_date, sale_cost-->
                                        <form class="card-body was-validated" action="javascript:void(0)" method="post" id="insertSaleForm" onsubmit="insertSale()">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertSaleVIN">VIN:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter VIN" id="insertSaleVIN" name="VIN" required />
                                                <div class="valid-feedback">Vehicle ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer vehicle ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertSaleEmployeeID">Employee ID:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter employee ID" id="insertSaleEmployeeID" name="employeeID" required />
                                                <div class="valid-feedback">Employee ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertSaleCustomerID">Customer ID:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter customer ID" id="insertSaleCustomerID" name="customerID" required />
                                                <div class="valid-feedback">Customer ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertSaleDealershipID">Dealership ID:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter Dealership ID" id="insertSaleDealershipID" name="dealershipID" required />
                                                <div class="valid-feedback">Dealership ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid dealership ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertSaleDate">Sale Date:</label>
                                                <input class="form-control" type="date" pattern="\d{4}-\d{2}-\d{2}" id="insertSaleDate" name="date" required />
                                                <div class="valid-feedback">Sale date looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid sale date.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertSaleCostGroup">Sale Cost:</label>
                                                <div class="input-group" id="insertSaleCostGroup">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input class="form-control rounded-right" type="text" pattern="^\d+(\.\d{2})?$" placeholder="Enter Cost" id="insertSaleCost" name="cost" required />
                                                    <div class="valid-feedback">Sale cost looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid sale cost in dollars.</div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Insert Sale">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="saleTab2">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager" && $_SESSION["employeeRole"] != "Salesperson") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager or a salesperson to update a sale order!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Update a sale order:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="updateFillSaleForm" onsubmit="updateFillSale()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateFillSaleNum">Fill in other values in the form below by entering a sale #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter sale #" id="updateFillSaleNum" name="saleNum" required />
                                                    <div class="valid-feedback">Sale number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer sale number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Fill Record Details" />
                                                </div>
                                            </form>
                                            <!--sale_num, vin, employee_id, customer_id, dealership_id, sale_date, sale_cost-->
                                            <label class="font-weight-bold" for="updateSaleForm">Fill in this form to update a sale record:</label>
                                            <form class="was-validated" action="javascript:void(0)" method="post" id="updateSaleForm" onsubmit="updateSale()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleNum">Sale #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter sale #" id="updateSaleNum" name="saleNum" required />
                                                    <div class="valid-feedback">Sale number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer sale number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleVIN">VIN:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter VIN" id="updateSaleVIN" name="VIN" required />
                                                    <div class="valid-feedback">Vehicle ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer vehicle ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleEmployeeID">Employee ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter employee ID" id="updateSaleEmployeeID" name="employeeID" required />
                                                    <div class="valid-feedback">Employee ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleCustomerID">Customer ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter customer ID" id="updateSaleCustomerID" name="customerID" required />
                                                    <div class="valid-feedback">Customer ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleDealershipID">Dealership ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter Dealership ID" id="updateSaleDealershipID" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid dealership ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleDate">Sale Date:</label>
                                                    <input class="form-control" type="date" pattern="\d{4}-\d{2}-\d{2}" id="updateSaleDate" name="date" required />
                                                    <div class="valid-feedback">Sale date looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid sale date.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateSaleCostGroup">Sale Cost:</label>
                                                    <div class="input-group" id="updateSaleCostGroup">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input class="form-control rounded-right" type="text" pattern="^\d+(\.\d{2})?$" placeholder="Enter Cost" id="updateSaleCost" name="cost" required />
                                                        <div class="valid-feedback">Sale cost looks good.</div>
                                                        <div class="invalid-feedback">Please enter a valid sale cost in dollars.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Update Sale">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="saleTab3">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager" && $_SESSION["employeeRole"] != "Salesperson") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager or a salesperon to delete a sale order!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Delete a sale order:</div>                      
                                        <div class="card-body">                                            
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="deleteSaleForm" onsubmit="deleteSale()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="deleteSaleNum">Delete a sale by entering a sale order #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter sale #" id="deleteSaleNum" name="saleNum" required />
                                                    <div class="valid-feedback">Sale order number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer sale order number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Delete Sale" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="saleTab4">
                                    <div class="card">
                                        <div class="card-header h5">Find a sale order:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="findSaleNumForm" onsubmit="findSaleNum()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="findSaleNumInput">Find a sale by entering a sale order number:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter sale #" id="findSaleNumInput" name="saleNum" required />
                                                    <div class="valid-feedback">Sale order number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer sale order number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Find sale by number" />
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                    <div id="findSaleTable"></div>
                                </div>
                                <div class="tab-pane fade" id="saleTab5">
                                    <form class="form-inline" id="saleOrderBy" action="javascript:void(0)" onsubmit="showAllSales()">
                                        <div class="form-group mr-2">
                                            <label for="orderBySale">Select order to display results:</label>
                                        </div>
                                        <div class="form-group mr-2">
                                            <!--sale_num, vin, employee_id, customer_id, dealership_id, sale_date, sale_cost-->
                                            <select class="form-control" name="orderBySale" id="orderBySale">
                                                <option value="sale_num asc" selected>Sale # Ascending</option>
                                                <option value="sale_num desc">Sale # Descending</option>                                                
                                                <option value="vin asc">VIN Ascending</option>
                                                <option value="vin desc">VIN Descending</option>
                                                <option value="employee_id asc">Employee ID Ascending</option>
                                                <option value="employee_id desc">Employee ID Descending</option>
                                                <option value="customer_id asc">Customer ID Ascending</option>
                                                <option value="customer_id desc">Customer ID Descending</option>
                                                <option value="dealership_id asc">Dealership ID Ascending</option>
                                                <option value="dealership_id desc">Dealership ID Descending</option>
                                                <option value="sale_date asc">Sale Date Ascending</option>
                                                <option value="sale_date desc">Sale Date Descending</option>
                                                <option value="sale_cost asc">Sale Cost Ascending</option>
                                                <option value="sale_cost desc">Sale Cost Descending</option>                                                
                                            </select>
                                        </div>
                                        <div class ="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Refresh Display" />
                                        </div>
                                    </form>
                                    <div id="allSalesTable"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="servicePill">
                            <ul class="nav nav-tabs" id="serviceTabs">
                                <li class="nav-item"><a data-toggle="tab" class="nav-link active" href="#serviceTab1">Insert</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#serviceTab2">Update</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#serviceTab3">Delete</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#serviceTab4">Find</a></li>
                                <li class="nav-item"><a data-toggle="tab" class="nav-link" href="#serviceTab5">Show All</a></li>
                            </ul>
                            <div class="tab-content p-4 bg-light border" id="serviceTabPanels">
                                <div class="tab-pane fade show active" id="serviceTab1">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager" && $_SESSION["employeeRole"] != "Mechanic") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager or a mechanic to insert a service job!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Insert a service job:</div>
                                        <!--vin, employee_id, customer_id, dealership_id, service_date, service_cost-->
                                        <form class="card-body was-validated" action="javascript:void(0)" method="post" id="insertServiceForm" onsubmit="insertService()">
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertServiceVIN">VIN:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter VIN" id="insertServiceVIN" name="VIN" required />
                                                <div class="valid-feedback">Vehicle ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer vehicle ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertServiceEmployeeID">Employee ID:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter employee ID" id="insertServiceEmployeeID" name="employeeID" required />
                                                <div class="valid-feedback">Employee ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertServiceCustomerID">Customer ID:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter customer ID" id="insertServiceCustomerID" name="customerID" required />
                                                <div class="valid-feedback">Customer ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertServiceDealershipID">Dealership ID:</label>
                                                <input class="form-control" type="number" min="1" step="1" placeholder="Enter Dealership ID" id="insertServiceDealershipID" name="dealershipID" required />
                                                <div class="valid-feedback">Dealership ID number looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid dealership ID number.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertServiceDate">Service Date:</label>
                                                <input class="form-control" type="date" pattern="\d{4}-\d{2}-\d{2}" id="insertServiceDate" name="date" required />
                                                <div class="valid-feedback">Service date looks good.</div>
                                                <div class="invalid-feedback">Please enter a valid service date.</div>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold" for="insertServiceCostGroup">Service Cost:</label>
                                                <div class="input-group" id="insertServiceCostGroup">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">$</span>
                                                    </div>
                                                    <input class="form-control rounded-right" type="text" pattern="^\d+(\.\d{2})?$" placeholder="Enter Cost" id="insertServiceCost" name="cost" required />
                                                    <div class="valid-feedback">Service cost looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid service cost in dollars.</div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <input type="submit" class="btn btn-primary" value="Insert Service">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="serviceTab2">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager" && $_SESSION["employeeRole"] != "Mechanic") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager or a mechanic to update a service job!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Update a service job:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="updateFillServiceForm" onsubmit="updateFillService()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateFillServiceNum">Fill in other values in the form below by entering a service #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter service #" id="updateFillServiceNum" name="serviceNum" required />
                                                    <div class="valid-feedback">Service number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer service number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <input class="btn btn-primary" type="submit" value="Fill Record Details" />
                                                </div>
                                            </form>
                                            <!--service_num, vin, employee_id, customer_id, dealership_id, service_date, service_cost-->
                                            <label class="font-weight-bold" for="updateServiceForm">Fill in this form to update a service record:</label>
                                            <form class="was-validated" action="javascript:void(0)" method="post" id="updateServiceForm" onsubmit="updateService()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceNum">Service #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter service #" id="updateServiceNum" name="serviceNum" required />
                                                    <div class="valid-feedback">Service number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer service number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceVIN">VIN:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter VIN" id="updateServiceVIN" name="VIN" required />
                                                    <div class="valid-feedback">Vehicle ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer vehicle ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceEmployeeID">Employee ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter employee ID" id="updateServiceEmployeeID" name="employeeID" required />
                                                    <div class="valid-feedback">Employee ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer employee ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceCustomerID">Customer ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter customer ID" id="updateServiceCustomerID" name="customerID" required />
                                                    <div class="valid-feedback">Customer ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer customer ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceDealershipID">Dealership ID:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter Dealership ID" id="updateServiceDealershipID" name="dealershipID" required />
                                                    <div class="valid-feedback">Dealership ID number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid dealership ID number.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceDate">Service Date:</label>
                                                    <input class="form-control" type="date" pattern="\d{4}-\d{2}-\d{2}" id="updateServiceDate" name="date" required />
                                                    <div class="valid-feedback">Service date looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid service date.</div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="updateServiceCostGroup">Service Cost:</label>
                                                    <div class="input-group" id="updateServiceCostGroup">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">$</span>
                                                        </div>
                                                        <input class="form-control rounded-right" type="text" pattern="^\d+(\.\d{2})?$" placeholder="Enter Cost" id="updateServiceCost" name="cost" required />
                                                        <div class="valid-feedback">Service cost looks good.</div>
                                                        <div class="invalid-feedback">Please enter a valid service cost in dollars.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input type="submit" class="btn btn-primary" value="Update Service">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="serviceTab3">
                                    <?php
                                        if($_SESSION["employeeRole"] != "Manager" && $_SESSION["employeeRole"] != "Mechanic") {
                                            echo "<div class='card bg-warning mb-2'><div class='card-body text-white'>You must be a manager or a mechanic to delete a service job!</div></div>";
                                        }
                                    ?>
                                    <div class="card">
                                        <div class="card-header h5">Delete a service job:</div>
                                        <div class="card-body">                                            
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="deleteServiceForm" onsubmit="deleteService()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="deleteServiceNum">Delete a service by entering a service job #:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter service #" id="deleteServiceNum" name="serviceNum" required />
                                                    <div class="valid-feedback">Service job number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer service job number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Delete Service" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="serviceTab4">
                                    <div class="card">
                                        <div class="card-header h5">Find a service order:</div>
                                        <div class="card-body">
                                            <form class="was-validated" method="post" action="javascript:void(0)" id="findServiceNumForm" onsubmit="findServiceNum()">
                                                <div class="form-group">
                                                    <label class="font-weight-bold" for="findServiceNumInput">Find a service by entering a service order number:</label>
                                                    <input class="form-control" type="number" min="1" step="1" placeholder="Enter service #" id="findServiceNumInput" name="serviceNum" required />
                                                    <div class="valid-feedback">Service order number looks good.</div>
                                                    <div class="invalid-feedback">Please enter a valid integer service order number.</div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <input class="btn btn-primary" type="submit" value="Find service by number" />
                                                </div>
                                            </form>
                                        </div>                                        
                                    </div>
                                    <div id="findServiceTable"></div>
                                </div>
                                <div class="tab-pane fade" id="serviceTab5">                                    
                                    <form class="form-inline" id="serviceOrderBy" action="javascript:void(0)" onsubmit="showAllServices()">
                                        <div class="form-group mr-2">
                                            <label for="orderByService">Select order to display results:</label>
                                        </div>
                                        <div class="form-group mr-2">
                                            <!--service_num, vin, employee_id, customer_id, dealership_id, service_date, service_cost-->
                                            <select class="form-control" name="orderByService" id="orderByService">
                                                <option value="service_num asc" selected>Service # Ascending</option>
                                                <option value="service_num desc">Service # Descending</option>                                                
                                                <option value="vin asc">VIN Ascending</option>
                                                <option value="vin desc">VIN Descending</option>
                                                <option value="employee_id asc">Employee ID Ascending</option>
                                                <option value="employee_id desc">Employee ID Descending</option>
                                                <option value="customer_id asc">Customer ID Ascending</option>
                                                <option value="customer_id desc">Customer ID Descending</option>
                                                <option value="dealership_id asc">Dealership ID Ascending</option>
                                                <option value="dealership_id desc">Dealership ID Descending</option>
                                                <option value="service_date asc">Service Date Ascending</option>
                                                <option value="service_date desc">Service Date Descending</option>
                                                <option value="service_cost asc">Service Cost Ascending</option>
                                                <option value="service_cost desc">Service Cost Descending</option>                                                
                                            </select>
                                        </div>
                                        <div class ="form-group">
                                            <input type="submit" class="btn btn-primary" name="submit" value="Refresh Display" />
                                        </div>
                                    </form>
                                    <div id="allServicesTable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        <script>
            $(document).ready(function(){                
                $("#customerTabs li:nth-child(5) a").on("click", function() {
                    console.log("refreshing customer table on tab click");
                    showAllCustomers();
                });
                $("#employeeTabs li:nth-child(5) a").on("click", function() {
                    console.log("refreshing employee table on tab click");
                    showAllEmployees();
                });
                $("#vehicleTabs li:nth-child(5) a").on("click", function() {
                    console.log("refreshing vehicle table on tab click");
                    showAllVehicles();
                });
                $("#dealershipTabs li:nth-child(5) a").on("click", function() {
                    console.log("refreshing dealership table on tab click");
                    showAllDealerships();
                });
                $("#saleTabs li:nth-child(5) a").on("click", function() {
                    console.log("refreshing sale table on tab click");
                    showAllSales();
                });
                $("#serviceTabs li:nth-child(5) a").on("click", function() {
                    console.log("refreshing service table on tab click");
                    showAllServices();
                });                
                // Log value when the radio input is checked on the insert employee tab.
                $("#insertEmployeeRoleRadio input").on("click", function() {
                    console.log($("#insertEmployeeRoleRadio input:checked").val() + " is checked!" );
                });
                // Log value when the radio input is checked on the update employee tab.
                $("#updateEmployeeRoleRadio input").on("click", function() {
                    console.log($("#updateEmployeeRoleRadio input:checked").val() + " is checked!" );
                });
            });
            
        </script>
    </body>
</html>
<?php
}

