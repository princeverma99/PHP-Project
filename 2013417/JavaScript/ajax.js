/*
 * Revision History
 * Prince Verma(2013417)    06-12-2020  Created ajax.js and implemented functionality
 */

//Declaring constant for Ready State and OK Status
const XHR_READY_STATE = 4;
const XHR_STATUS_OK = 200;

//Error Handling function which will alert the user about the error
function handleError(error)
{
    alert("Error Occured: ", error);
}

//searchPurchases() called by purchases.php on clicking search button
function searchPurchases()
{
    try
    {
        //Variable to perform an AJAX request
        var xhr = getXmlHttpRequest();
        xhr.onreadystatechange = function()
        {
            //AJAX ready states
            //0: unitialized
            //1: Loading
            //2: Loaded
            //3: Interactive
            //4: Completed
            if(xhr.readyState == XHR_READY_STATE && xhr.status == XHR_STATUS_OK)
            {
                //response is HTML
                //xhr.responseText
                document.getElementById('searchResults').innerHTML = xhr.responseText;
            }
        }
        xhr.open("POST", 'searchPurchases.php');
        //specify that the request does not contain binary data
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
        //getting the value from the textBox date
        var searchQuery = document.getElementById('searchQuery').value;
        xhr.send('searchQuery=' + searchQuery);
    }
    catch(error)
    {
        //if any error occurs, handleError(error) will be called
        handleError(error);
    }
}

function getXmlHttpRequest()
{
    try
    {
        var xhr = null;
        if(window.XMLHttpRequest)   //for all browsers except Internet Explorer
        {
            xhr = new XMLHttpRequest();
        }
        else
        {
            //code for Internet Explorer
            if(window.ActiveXObject)
            {
                try
                {
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(error)
                {
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
            }
            else
            {
                alert("Your browser does not support XMLHTTPRequest objects");
            }
        }
        return xhr;
    }
    catch(error)
    {
        //if any error occurs, handleError(error) will be called
        handleError(error);
    }
}