//Customer javascript functions for forms.
function showAllCustomers() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "customer/showAllCustomers.php",             
        dataType: "html",
        data: $("#customerOrderBy").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#allCustomersTable").html(data);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function insertCustomer() {
    $.ajax({
        method: "POST",
        url: "customer/insertCustomer.php",
        data: $('#insertCustomerForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#insertCustomerForm").trigger("reset");
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

function updateFillCustomer() {
    $.ajax({
        url: 'customer/updateFillCustomer.php',
        type: 'POST',
        data: $('#updateFillCustomerForm').serialize(),
        dataType: 'json'
    }).done(function(data, textStatus, jqXHR) {
        $("#updateCustomerID").val(data.id);
        $("#updateCustomerFname").val(data.fname);
        $("#updateCustomerLname").val(data.lname);
        $("#updateCustomerEmail").val(data.email);
        $("#updateCustomerPhone").val(data.phone);
        $("#updateFillCustomerForm").trigger("reset");
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
        $("#updateFillCustomerForm").trigger("reset");                    
    });
}

function updateCustomer() {
    $.ajax({
        method: "POST",
        url: "customer/updateCustomer.php",
        data: $('#updateCustomerForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#updateCustomerForm").trigger("reset");
        console.log("Update status: " + textStatus);
        console.log(data);
        //console.log(jqXHR.responseText);
        alert(data);                        
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Update status: " + textStatus);
        console.log(jqXHR.responseText);
        console.log(errorThrown);
        alert(jqXHR.responseText);
    });
}

function deleteCustomer() {
    $.ajax({
        method: "POST",
        url: "customer/deleteCustomer.php",
        data: $('#deleteCustomerForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#deleteCustomerForm").trigger("reset");
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

function findCustomerID() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "customer/findCustomerID.php",             
        dataType: "html",
        data: $("#findCustomerIDForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#findCustomerTable").html(data);
        $("#findCustomerIDForm").trigger("reset");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

