function showAllSales() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "sale/showAllSales.php",             
        dataType: "html",
        data: $("#saleOrderBy").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#allSalesTable").html(data);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function findSaleNum() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "sale/findSaleNum.php",             
        dataType: "html",
        data: $("#findSaleNumForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#findSaleTable").html(data);
        $("#findSaleNumForm").trigger("reset");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function deleteSale() {
    $.ajax({
        method: "POST",
        url: "sale/deleteSale.php",
        data: $('#deleteSaleForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#deleteSaleForm").trigger("reset");
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

function insertSale() {
    $.ajax({
        method: "POST",
        url: "sale/insertSale.php",
        data: $('#insertSaleForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#insertSaleForm").trigger("reset");
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

function updateFillSale() {
    $.ajax({
        url: 'sale/updateFillSale.php',
        type: 'POST',
        data: $('#updateFillSaleForm').serialize(),
        dataType: 'json'
    }).done(function(data, textStatus, jqXHR) {
        // vin, employee_id, customer_id, dealership_id, service_date, service_cost
        console.log(data);
        $("#updateSaleNum").val(data.saleNum);
        $("#updateSaleVIN").val(data.vin);
        $("#updateSaleEmployeeID").val(data.employeeID);
        $("#updateSaleCustomerID").val(data.customerID);
        $("#updateSaleDealershipID").val(data.dealershipID);
        $("#updateSaleDate").val(data.date);
        $("#updateSaleCost").val(data.cost);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText);
        $("#updateFillSaleForm").trigger("reset");                    
    });
}

function updateSale() {
    $.ajax({
        method: "POST",
        url: "sale/updateSale.php",
        data: $('#updateSaleForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#updateFillSaleForm").trigger("reset");
        $("#updateSaleForm").trigger("reset");
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