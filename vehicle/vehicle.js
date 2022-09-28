function showAllVehicles() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "vehicle/showAllVehicles.php",             
        dataType: "html",
        data: $("#vehicleOrderBy").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#allVehiclesTable").html(data);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}
function insertVehicle() {
    $.ajax({
        method: "POST",
        url: "vehicle/insertVehicle.php",
        data: $('#insertVehicleForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#insertVehicleForm").trigger("reset");
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

