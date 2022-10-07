function showAllDealerships() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "dealership/showAllDealerships.php",             
        dataType: "html",
        data: $("#dealershipOrderBy").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#allDealershipsTable").html(data);
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function findDealershipID() {
    //Note that $ is short for "jQuery" function, here we call
    //ajax function object to perform AJAX request.
    $.ajax({    
        method: "POST",
        url: "dealership/findDealershipID.php",             
        dataType: "html",
        data: $("#findDealershipIDForm").serialize()
    //Use jQuery done and fail deferred/promise methods called using 
    //anonymous function callbacks with chaining.
    }).done(function(data, textStatus, jqXHR) {
        console.log("Record retrieval status: " + textStatus);
        //Uncomment to see raw HTML returned
        //console.log(data);
        //console.log(jqXHR.responseText);
        //Insert html into tableContainer div
        $("#findDealershipTable").html(data);
        $("#findDealershipIDForm").trigger("reset");
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("Record retrieval status: " + textStatus);
        console.log("Response text: " + jqXHR.responseText);
        console.log("Error thrown: " + errorThrown);
        alert(jqXHR.responseText);
    });
}

function deleteDealership() {
    $.ajax({
        method: "POST",
        url: "dealership/deleteDealership.php",
        data: $('#deleteDealershipForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#deleteDealershipForm").trigger("reset");
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

function insertDealership() {
    $.ajax({
        method: "POST",
        url: "dealership/insertDealership.php",
        data: $('#insertDealershipForm').serialize()
    }).done(function(data, textStatus, jqXHR) {
        $("#insertDealershipForm").trigger("reset");
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