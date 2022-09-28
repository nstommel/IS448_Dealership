function insertEmployee() {
    $.ajax({
        method: "POST",
        url: "employee/insertEmployee.php",
        data: $('#insertEmployeeForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#insertEmployeeForm").trigger("reset");
        console.log("Insertion status: " + textStatus);
        console.log(data);
        //console.log(jqXHR.responseText);
        alert(data);                        
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Insertion status: " + textStatus);
        console.log(jqXHR.responseText);
        console.log(errorThrown);
        alert(jqXHR.responseText);
    });
}
function showAllEmployees() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "employee/showAllEmployees.php",             
        dataType: "html",
        data: $("#employeeOrderBy").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#allEmployeesTable").html(data);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}
function findEmployeeID() {
    $.ajax({    
        method: "POST",
        url: "employee/findEmployeeID.php",             
        dataType: "html",
        data: $("#findEmployeeIDForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#findEmployeeTable").html(data);
        $("#findEmployeeIDForm").trigger("reset");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}
function deleteEmployee() {
    $.ajax({
        method: "POST",
        url: "employee/deleteEmployee.php",
        data: $('#deleteEmployeeForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#deleteEmployeeForm").trigger("reset");
        console.log("Delete status: " + textStatus);
        console.log(data);
        alert(data);                        
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Delete status: " + textStatus);
        console.log(jqXHR.responseText);
        console.log(errorThrown);
        alert(jqXHR.responseText);
    });
}
function updateFillEmployee() {
    $.ajax({
        url: 'employee/updateFillEmployee.php',
        type: 'POST',
        data: $('#updateFillEmployeeForm').serialize(),
        dataType: 'json'
    }).done(function(data, textStatus, jqXHR) {
        $("#updateEmployeeID").val(data.employeeID);
        $("#updateEmployeeDealershipID").val(data.dealershipID);
        $("#updateEmployeeFname").val(data.fname);
        $("#updateEmployeeLname").val(data.lname);
        $("#updateEmployeeEmail").val(data.email);
        $("#updateEmployeePhone").val(data.phone);
        //Check the appropriate role box that corresponds to the employee information retrieved
        if(data.role === "Manager") {                        
            $("#updateEmployeeRoleRadio input[name=employeeRole][value='Manager']").prop("checked",true);
        } else if(data.role === "Salesperson") {                       
            $("#updateEmployeeRoleRadio input[name=employeeRole][value='Salesperson']").prop("checked",true);                        
        } else if(data.role === "Mechanic") {                      
            $("#updateEmployeeRoleRadio input[name=employeeRole][value='Mechanic']").prop("checked",true);
        } else {
            console.log("Error, role = " + data.role);
        }
        $("#updateFillEmployeeForm").trigger("reset");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
        $("#updateFillEmployeeForm").trigger("reset");                    
    });
}
function updatePassword() {
    $.ajax({    
        method: "POST",
        url: "employee/updatePassword.php",             
        data: $("#updatePasswordForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Update password status: " + textStatus);                    
        $("#updatePasswordForm").trigger("reset");
        alert("Password succesfully updated!");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Update password status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}
function updateEmployee() {
    $.ajax({    
        method: "POST",
        url: "employee/updateEmployee.php",             
        data: $("#updateEmployeeForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Update status: " + textStatus);                    
        $("#updateEmployeeForm").trigger("reset");
        alert("Records successfully updated!");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Update employee status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

