function showAllServices() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "service/showAllServices.php",             
        dataType: "html",
        data: $("#serviceOrderBy").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#allServicesTable").html(data);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function findServiceNum() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "service/findServiceNum.php",             
        dataType: "html",
        data: $("#findServiceNumForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#findServiceTable").html(data);
        $("#findServiceNumForm").trigger("reset");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function deleteService() {
    $.ajax({
        method: "POST",
        url: "service/deleteService.php",
        data: $('#deleteServiceForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#deleteServiceForm").trigger("reset");
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

function insertService() {
    $.ajax({
        method: "POST",
        url: "service/insertService.php",
        data: $('#insertServiceForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#insertServiceForm").trigger("reset");
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

function updateFillService() {
    $.ajax({
        url: 'service/updateFillService.php',
        type: 'POST',
        data: $('#updateFillServiceForm').serialize(),
        dataType: 'json'
    }).done(function(data, textStatus, jqXHR) {
        // vin, employee_id, customer_id, dealership_id, service_date, service_cost
        console.log(data);
        $("#updateServiceNum").val(data.serviceNum);
        $("#updateServiceVIN").val(data.vin);
        $("#updateServiceEmployeeID").val(data.employeeID);
        $("#updateServiceCustomerID").val(data.customerID);
        $("#updateServiceDealershipID").val(data.dealershipID);
        $("#updateServiceDate").val(data.date);
        $("#updateServiceCost").val(data.cost);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
        $("#updateFillServiceForm").trigger("reset");                    
    });
}

function updateService() {
    $.ajax({
        method: "POST",
        url: "service/updateService.php",
        data: $('#updateServiceForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#updateFillServiceForm").trigger("reset");
        $("#updateServiceForm").trigger("reset");
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