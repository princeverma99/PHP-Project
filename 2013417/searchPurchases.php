<?php
    /*
     * Revision History
     * Prince Verma(2013417)    06-12-2020   created searchPurchases.php
     * Prince Verma(2013417)    11-12-2020   Implemented the filterPurchases() from class purchases
     */
    #including the PHPFunctions file into the webpage
    include_once 'PHP Functions/PHPFunctions.php';
    #including all the required classes
    include_once CLASS_PURCHASES;
    include_once CLASS_CUSTOMER;
    include_once CLASS_PRODUCT;
    #session_start() to start or resume existing session
    session_start();
    #if the user has clicked on search button
    if(isset($_POST['searchQuery']))
    {
        #using htmlspecialchars() to prevent SQL Injection
        $searchQuery = htmlspecialchars($_POST['searchQuery']);
        #creating the object of class purchases
        $purchases = new purchases();
        #using foreach to access each item of the purchases
        foreach ($purchases->items as $purchase)
        {
            #removing all the data from the array which was added when the $purchases object was created
            $purchases->remove($purchase->getPurchaseUUID());
        }
        #calling the filterPurchase to select all the purchases based on customerUUID and search date
        $purchases->filterPurchases($searchQuery, $_SESSION['user']);
        #creating the object of class customer
        $customer = new customer();
        #creating object of class product
        $product = new product();
        #Loading all the data of the customer based on sesion variable - user
        $customer->Load($_SESSION['user']);
  
        ?>
    <!--Table Purchases-->
    <table id="tblPurchases">
        <tr>
            <th></th>
            <th>Product Code</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>City</th>
            <th>Comments</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Sub Total</th>
            <th>Taxes</th>
            <th>Grand Total</th>
        </tr>
<?php
        #using foreach to go through every purchase made by the logged user
        foreach($purchases->items as $purchase)
        {
            #Loading the product data using productUUID
            $product->Load($purchase->getProductUUID());
            echo "<tr>";
            #Assigning the purchaeUUID to the value of <input type="hidden"> to be used for deleting data
            ?>
            <td>
            <form method="POST" action="<?php echo PURCHASES_PAGE; ?>">
                <input type="hidden" name="purchaseUUID" value="<?php echo $purchase->getPurchaseUUID(); ?>">
                <input type="submit" name="delete" value="Delete" class="button">
            </form>
            </td>
            <?php 
            #Displaying the data to the user
            echo "<td>".$product->getProductCode()."</td>";
            echo "<td>".$customer->getFirstname()."</td>";
            echo "<td>".$customer->getLastname()."</td>";
            echo "<td>".$customer->getCity()."</td>";
            echo "<td>".$purchase->getComments()."</td>";
            echo "<td>".$product->getPrice().' $'."</td>";
            echo "<td>".$purchase->getQuantity()."</td>";
            echo "<td>".$purchase->getSubTotal().' $'."</td>";
            echo "<td>".$purchase->getTaxes().' $'."</td>";
            echo "<td>".$purchase->getGrandTotal().' $'."</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }
?>

