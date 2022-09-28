<?php

session_start();
unset($_SESSION["employeeID"]);
unset($_SESSION["employeeRole"]);
//Avoid destroying the session, merely unset employeeID and employeeROle keys 
//so user cannot get back in without authenticating.
//session_destroy(); 
header("location: ../index.php");
