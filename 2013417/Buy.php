<?php
    /*
     * Revision History
     * Prince Verma(2013417)    06-12-2020  Created and completed Buy.php
     */
    #including the PHPFunctions file into the webpage
    include_once 'PHP Functions/PHPFunctions.php';
    #including the required classes
    include_once CLASS_PRODUCTS;
    include_once CLASS_PRODUCT;
    include_once CLASS_PURCHASE;
    #Calling pageHeade() and passing the title of the page
    pageHeader("Buy");
    #Displaying the navigation menu
    navigationMenu();
    #Using session_start() to start or resume existing session
    session_start();
    #Declaring variables
    $comments = '';
    $productCode = '';
    $commentsErrorMessage = '';
    $quantity = '';
    $quantityErrorMessage = '';
    #if the session variable - user is set with the customerUUID then the user can buy products 
    if(isset($_SESSION['user']))
    {
        #creating object of class products which will select all the products and add it to collection
        $products = new products();
        #creating object of class purchase
        $purchase = new purchase();
        
        #if user clicks on submit button
        if(isset($_POST['submit']))
        {
            #using htmlspecialchars() to prevent SQL Injection
            $productUUID = htmlspecialchars($_POST['productUUID']);
            $comments = htmlspecialchars($_POST['comments']);
            $quantity = htmlspecialchars($_POST['quantity']);
            
            #Validating and setting the field of class purchase with the data entered by the user and display the returned message
            $commentsErrorMessage = $purchase->setComments($comments);
            $quantityErrorMessage = $purchase->setQuantity($quantity);
            #If data entered by the user does not contain any errors
            if($commentsErrorMessage == '' && $quantityErrorMessage == '')
            {
                #Using foreach to go through each product
                foreach($products->items as $product)
                {
                    #Checking that the productUUID from collection is matched with the productUUID entered by the user
                    if($product->getProductUUID() == $productUUID)
                    {
                        #Assigning the subtotal, taxes and grandtotal of the product selected by iser
                        $purchase->setSubTotal($product->getPrice());
                        $purchase->setTaxes();
                        $purchase->setGrandTotal();
                    }
                }
                #Assigning the productUUID with the product selected by user
                $purchase->setProductUUID($productUUID);
                #Assigning the customerUUID with the customerUUID from user session variable
                $purchase->setCustomerUUID($_SESSION['user']);
                
                #Calling Save() to save the data
                if($purchase->Save())
                {
                    #If the data is saved, clearing the form text fields
                    $comments = '';
                    $quantity = '';
                    echo "<h3 class='buyInfo'>Purchase Done</h3>";
                }
                #if the data is not saved, it will show error message
                else
                {
                    echo "<h3 class='buyInfo'>Error Occured, Please try again</h3>";
                }
            }
        }
    }
    else
    {
        #Displaying the login form if the user is not logged in
        Login();
        #Displaying page footer
        pageFooter();
        #Ending the program
        die();
    }
?>
<!--Buy Form-->
<h4 class="required">* = required</h4>
<form method="POST">
    <p>
        <label>Product Code:<span class="required">*</span></label>
        <select name="productUUID">
        <?php
        #using foreach to go through each and every product and displaying the product code and description to the user
        foreach($products->items as $product)
        {
            ?><option value="<?php echo $product->getProductUUID(); ?>"><?php echo $product->getProductCode()." - ".$product->getDescription();?></option>
        <?php
        }
        ?>
        </select>
    </p>
    <p>
        <label>Comments:</label>
        <input type="text" name="comments" value="<?php echo $comments;?>"/> <span class="validation"><?php echo $commentsErrorMessage;?></span>
    </p>
    <p>
        <label>Quantity<span class="required">*</span>:  </label>
        <input type="text" name="quantity" value="<?php echo $quantity;?>"/> <span class="validation"><?php echo $quantityErrorMessage;?></span>
    </p>
    <p>
        <input type="submit" value="Buy" name="submit" class="button"/>
    </p>
</form>
<?php
    #Displaying the logout form to the logged user
    Logout();
    #Displaying the footer
    pageFooter();
?>