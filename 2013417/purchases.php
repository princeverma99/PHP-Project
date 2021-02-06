<?php
    /*
     * Revision History
     * Prince Verma(2013417)    06-12-2020  created purchases.php and implemented AJAX(Delete button pending)
     * Prince Verma(2013417)    09-12-2020  Delete button functionality implemented and Completed purchases.php 
     */
    #including the PHPFunctions file into the webpage
    include_once 'PHP Functions/PHPFunctions.php';
    #including the necessary files
    include_once DATABASE_CONNECTION_FILE;
    include_once CLASS_PURCHASE;
    pageHeader("Purchases");    #Calling the pageHeader() and passing the title parameter
    navigationMenu();   #calling the Navigation Menu
    session_start();    #session_start() to start or resume existing session
    #if the session variable - user is set with the customerUUID then the user will be able to perform functions
    if(isset($_SESSION['user']))
    {
        #When the user clicks on delete button
        if(isset($_POST['delete']))
        {
            #creating the object of class purchase
            $purchase = new purchase();
            #Calling Delete() to delete the purchase using purchaseUUID
            if($purchase->Delete($_POST['purchaseUUID']))
            {
                #Displaying the delete message
                echo "<h3 class='deleteInfo'>Purchase Deleted</h3>";
            }
        }
    }
    #if the user is not logged in
    else
    {
        #display the login form
        Login();
        #display page footer
        pageFooter();
        #ending the program
        die();
    }
?>
    <div class="purchasesForm">
            <label>Show Purchases made on this day or later: </label>
            <input type="text" placeholder="2020-03-13" id="searchQuery">
        </p>
        <p>
            <button onclick="searchPurchases()" class="button" name="search">Search</button>
        </p>
    </div>

    <div id="searchResults">
    </div>

<?php   
    #Displaying the logout form to the logged user
    Logout();
    #displaying the page footer
    pageFooter();
?>