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


