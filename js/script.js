$scrapeUrl = "";

$(document).ready(function()
{
    //onclick event for addnew button
    $("#addNew").on('click', function()
    {
        $("#tableManager").modal('show');
    });

    $("#tableManager").on('hidden.bs.modal', function()
    {
        $("#editContent").fadeIn();
        location.reload();
        $("#scrapeContent").fadeOut();
        $("#editRowID").val(0);
        $("#prospektName").val("");
        $("#proUrl").val("");
        $("#proUrlAllabolag").val("");
        $("#epost").val("");
        $("#comment").val("");
        $("#closeBtn").fadeIn();
        $("#manageBtn").attr('value', 'Spara i databasen').attr('onclick', "manageData('addNew')").fadeIn();
    });

    //load 10 prospekts by one ajax call
    getExistingData(0, 10);

});

function deleteRow(rowID)
{
    if(confirm('Är du säker att du vill radera detta prospekt???'))
    {
        $.ajax
        ({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'text',
            data: 
                {
                    key: 'deleteRow',
                    rowID: rowID
                }, success: function (response)
                {
                    $("#prospektName"+rowID).parent().remove();
                    alert(response);
                    location.reload();
                }
        });
    }
}

function scrapePage(rowID)
{
    $.ajax
    ({
        url: 'ajax.php',
        method: 'POST',
        dataType: 'json',
        data: 
            {
                key: 'getRowData',
                rowID: rowID
            }, success: function (response)
            {
                $("#editContent").fadeOut();
                $("#scrapeContent").fadeIn();
                $("#editRowID").val(rowID);
                $("#prospektName").val(response.prospektName);
                $("#proUrl").val(response.proUrl);
                $("#proUrlAllabolag").val(response.proUrlAllabolag).fadeOut();
                $("#epost").val(response.epost).fadeOut();
                $("#comment").val(response.comment).fadeOut();
                $("#closeBtn").fadeOut();
                $("#manageBtn").attr('value', 'Scrape Page').attr('onclick', "manageData('scrapePage')").fadeOut();

                var baseUrl = response.proUrl.toLowerCase();

                if( (baseUrl.includes("http://")) || (baseUrl.includes("https://")) )
                {
                    if( (baseUrl.includes("http://www.")) || (baseUrl.includes("https://www.")) )
                    {
                    }else
                    {
                        var lastIndex = baseUrl.lastIndexOf('/');

                        if(lastIndex == 6)
                        {
                            baseUrl = "http://www." + baseUrl.slice(7);
    
                        }else if(lastIndex == 7)
                        {
                            baseUrl = "https://www." + baseUrl.slice(8);

                        }
                    }
                } else
                {
                    if(baseUrl.includes("www."))
                    {
                        baseUrl = "https://" + baseUrl;
                    }
                    else
                    {
                        baseUrl = "https://www." + baseUrl;
                    }                    
                }
                $(".modal-body #scrapeContent #proUrlScrape").val(baseUrl);
                $(".modal-body #scrapeContent #inputProspektName").val(response.prospektName);
                $(".modal-title").html(response.prospektName);
                $("#tableManager").modal('show');
            }
    });
}

function editProspekt(rowID)
{
    $.ajax
        ({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'json',
            data: 
                {
                    key: 'getRowData',
                    rowID: rowID
                }, success: function (response) 
                {
                    $("#editContent").fadeIn();
                    $("#scrapeContent").fadeOut();
                    $("#editRowID").val(rowID);
                    $("#prospektName").val(response.prospektName);
                    $("#proUrl").val(response.proUrl);
                    $("#proUrlAllabolag").val(response.proUrlAllabolag);
                    $("#epost").val(response.epost);
                    $("#comment").val(response.comment);
                    $("#closeBtn").fadeIn();
                    $("#manageBtn").attr('value', 'Spara ändringar').attr('onclick', "manageData('updateRow')");
    
                    $(".modal-title").html(response.prospektName);
                    $("#tableManager").modal('show');
                }
        });
}

//get data to show in table
function getExistingData(start, limit)
{
    $.ajax
    ({
        url: 'ajax.php',
        method: 'POST',
        dataType: 'text',
        data: 
            {
                key: 'getExistingData',
                start: start,
                limit: limit,
            }, success: function (response)
            {
                if( 'end' != response)
                {
                    //get dynamically all data
                    $('tbody').append(response);
                    start += limit;
                    getExistingData(start, limit);
                }
                else
                {
                    //call datatable library
                    $(".table").DataTable(); 

                }
            }
    });
}

//addnew = key in modal-footer onclick
function manageData(key)
{
    //putt content from field in modal-body into variable name
    var prospektnamn = $("#prospektName");
    var proUrl = $("#proUrl");
    var proUrlAllabolag = $("#proUrlAllabolag");
    var epost = $("#epost");
    var kommentar = $("#comment");
    var editRowID = $("#editRowID");

    //check if there is any information in modal-body
    //call function isNotEmpty with variable created above
    if(isNotEmpty(prospektnamn))
    {
        $.ajax
        ({
            url: 'ajax.php',
            method: 'POST',
            dataType: 'text',
            data:
            {
                //properties
                //variables after : = variables created above
                key: key,
                prospektnamnSend: prospektnamn.val(),
                proUrlSend: proUrl.val(),
                proUrlAllabolagSend: proUrlAllabolag.val(),
                epostSend: epost.val(),
                kommentarSend: kommentar.val(),
                rowID: editRowID.val()
            }, success: function (response) //response is from the server
                {
                    //this part of the code will be execute as we get response from the server
                    if (response != "success")
                    {
                        alert(response);
                        location.reload();
                    }
                    else
                    {
                        $("#prospektName_"+editRowID.val()).html(prospektnamn.val());
                        prospektnamn.val('');
                        proUrl.val('');
                        proUrlAllabolag.val('');
                        epost.val(''),
                        kommentar.val('');
                        $("#tableManager").modal('hide');
                        $("#manageBtn").attr('value', 'Add').attr('onclick', "manageData('updateRow')");
                        location.reload();
                    }
                }
        });
    }

    function isNotEmpty(caller) 
    {
        //if the variable created in manageData is empty (which means the field was empty)
        if (caller.val() == '')
        {
            caller.css('border', '1px solid red');
            return false;
        } 
        else
        {
            caller.css('border', '');
        }
        
        return true;
    }              
  }