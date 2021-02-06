<?php
/*
 * Revision History
 * Prince Verma(2013417)    06-12-2020  Created class purchase, declared all the fields and implemented get, set and Save functions    
 * Prince Verma(2013417)    08-12-2020  added Load() and Delete()
 * Prince Verma(2013417)    09-12-2020  Changed field product_code to product_uuid and changed functions accordingly
 */
#including the PHPFunctions file into the webpage
include_once 'PHP Functions/PHPFunctions.php';
#including database connection file
include_once DATABASE_CONNECTION_FILE;
#Defining constants
define("QUANTITY_MAX_VALUE",99);
define("QUANTITY_MIN_VALUE",1);
define("COMMENTS_MAX_LENGTH",200);
define("TAX_RATE", 15.2);

class purchase
{
    #fields of class purchase
    private $purchase_uuid = '';
    private $customer_uuid = '';
    private $product_uuid = '';
    private $quantity = 0;
    private $comments = '';
    private $subtotal = 0.0;
    private $taxes = 0.0;
    private $grandtotal = 0.0;
    
    #constructor of class purchase with optional parameters
    public function __construct($purchase_uuid = '' , $customer_uuid = '' ,$product_uuid = '', $quantity = '', $comments = '', $subtotal = '', $taxes = '', $grandtotal = '') 
    {
        $this->purchase_uuid = $purchase_uuid;
        $this->customer_uuid = $customer_uuid;
        $this->product_uuid = $product_uuid;
        $this->quantity = $quantity;
        $this->comments = $comments;
        $this->subtotal = $subtotal;
        $this->taxes = $taxes;
        $this->grandtotal = $grandtotal;
    }
    
    #Function to get purchaseUUID
    function getPurchaseUUID()
    {
        return $this->purchase_uuid;
    }
    #Function to return customerUUID
    function getCustomerUUID()
    {
        return $this->customer_uuid;
    }
    #Function to assign customerUUID
    function setCustomerUUID($customer_uuid)
    {
        $this->customer_uuid = $customer_uuid;
    }
    #Function to return productUUID
    function getProductUUID()
    {
        return $this->product_uuid;
    }
    #Function to set productUUID
    function setProductUUID($productUUID)
    {
        $this->product_uuid = $productUUID;
    }
    #function to get the subtotal of purchase
    function getSubTotal()
    {
        return $this->subtotal;
    }
    #function to assign the subtotal which is calculated as Quantity * price and rounding the data to 2 decimal places
    function setSubTotal($price)
    {
        $this->subtotal = round($this->quantity * $price, 2);
    }
    
    #function to return the amount of taxes of product
    function getTaxes()
    {
        return $this->taxes;
    }
    #function to set the taxes to be calcualted using the TAX RATE and rounding the data to 2 decimal points
    function setTaxes()
    {
        $this->taxes = round($this->subtotal*TAX_RATE/100, 2);
    }
    
    #function to get the grand total
    function getGrandTotal()
    {
        return $this->grandtotal;
    }
    #function to set the grandtotal by adding subtotal and taxes and rounding to 2 decimal points
    function setGrandTotal()
    {
        $this->grandtotal = round($this->subtotal + $this->taxes , 2);
    }
    
    #function to return the quantity of each product
    function getQuantity()
    {
        return $this->quantity;
    }
    
    #function to validate and set the quantity field
    function setQuantity($newQuantity)
    {
        if(strpos($newQuantity,".") == false)  #checking that the quantity does not contain floating values
            {
                if(is_numeric($newQuantity) && !is_float($newQuantity))   #checking that the quantity is numeric and does not contain floating point numbers
                {
                    if($newQuantity > QUANTITY_MAX_VALUE)  #Validating that the quantity does not exceed the max value
                    {   
                        return "Quantity cannot be more than ".QUANTITY_MAX_VALUE;
                    }
                    else if($newQuantity < QUANTITY_MIN_VALUE) #validating that the quantity is not less than 1
                    {
                        return "Quantity cannot be less than ".QUANTITY_MIN_VALUE;
                    }
                }
                else if($newQuantity == "")    #Checking that the quantity is not empty
                {
                    return "Quantity cannot be Empty";
                }   
                else    #If the quantity is not numeric than it will show error message
                {
                    return "Quantity is not Numeric";
                }
            }
        if(strpos($newQuantity, "."))    #If the quantity contains decimals or floating point numbers that it will show error message
        {
            return "Decimals are not allowed";
        }
        else #assigning if the data is valid
        {
            $this->quantity = $newQuantity;
        }
    }
    
    #function to get the comments of purchase
    function getComments()
    {
        return $this->comments;
    }
    #function to set comments field with the data after validation
    function setComments($newComments)
    {
        #comments validation
        if(mb_strlen($newComments) > COMMENTS_MAX_LENGTH)  #validating whether the comments are not more than max length
        {
            return "Comments cannot contain more than ".COMMENTS_MAX_LENGTH." characters";
        }
        else    #assigning when the data is validated
        {
            $this->comments = $newComments;
        }    
    }
    
    #function to load the data of particular purchase based on purchaseUUID
    public function Load($purchase_uuid)
    {
        #Using connection string
        global $connection;
        #SQL Query to run procedure purchase_load with paramteres
        $sqlQuery = "CALL purchase_load(:p_purchase_uuid)";
        #Preparing the PDOStatement for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #binding the parameters of the procedure
        $PDOStatement->bindParam(':p_purchase_uuid', $purchase_uuid);
        #executing the procedure
        $PDOStatement->execute();
        #Fetching the data from the procedure
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            #Assigning the data to the fields with the data fetched from the database
            $this->purchase_uuid = $row['purchase_uuid'];
            $this->customer_uuid = $row['customer_uuid'];
            $this->product_uuid = $row['product_uuid'];
            $this->quantity = $row['quantity'];
            $this->comments = $row['comments'];
            $this->subtotal = $row['subtotal'];
            $this->taxes = $row['taxes'];
            $this->grandtotal = $row['grandtotal'];
            return true;
        }
        #Closing the cursor to allow other statements to be executed properly
        $PDOStatement->closeCursor();
    }
    
    public function Save()
    {
        #using $connection from database-connection.php
        global $connection;
        if($this->purchase_uuid == '')
        {
            #SQL Query for procedure purchase_insert with paramters
            $sqlQuery = "CALL purchase_insert(:p_customer_uuid, :p_product_uuid, :p_quantity, :p_comments, :p_subtotal, :p_taxes, :p_grandtotal)";
            #Preparing the PDOStatement for execution
            $PDOStatement = $connection->prepare($sqlQuery);
            #binding the parameters of the procedure
            $PDOStatement->bindParam(':p_customer_uuid', $this->customer_uuid);
            $PDOStatement->bindParam(':p_product_uuid', $this->product_uuid);
            $PDOStatement->bindParam(':p_quantity', $this->quantity);
            $PDOStatement->bindParam(':p_comments', $this->comments);
            $PDOStatement->bindParam(':p_subtotal', $this->subtotal);
            $PDOStatement->bindParam(':p_taxes', $this->taxes);
            $PDOStatement->bindParam(':p_grandtotal', $this->grandtotal);
            #Executing the SQL Query
            #If the rows of the table are affected(means inserted) then return true otherwise false
            $affectedRows = $PDOStatement->execute(); 
            if($affectedRows == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
            #Closing the cursor to enable other statements to be executed properly
            $PDOStatement->closeCursor();
        }
        else
        {
            #SQL Query for procedure purchase_update with parameters
            $sqlQuery = "CALL purchase_update(:p_purchase_uuid, :p_customer_uuid, :p_product_uuid, :p_quantity, :p_comments, :p_subtotal, :p_taxes, :p_grandtotal)";
            #Preparing the PDOStatement for execution
            $PDOStatement = $connection->prepare($sqlQuery);
            #binding the parameters of the procedure
            $PDOStatement->bindParam(':p_purchase_uuid', $this->purchase_uuid);
            $PDOStatement->bindParam(':p_customer_uuid', $this->customer_uuid);
            $PDOStatement->bindParam(':p_product_uuid', $this->product_uuid);
            $PDOStatement->bindParam(':p_quantity', $this->quantity);
            $PDOStatement->bindParam(':p_comments', $this->comments);
            $PDOStatement->bindParam(':p_subtotal', $this->subtotal);
            $PDOStatement->bindParam(':p_taxes', $this->taxes);
            $PDOStatement->bindParam(':p_grandtotal', $this->grandtotal);
            #Executing the SQL Query
            $PDOStatement->execute(); 
            #Closing the cursor to enable other statements to be executed properly
            $PDOStatement->closeCursor();
            return true;
        }
    }
    
    public function Delete($purchaseUUID)
    {
        #using $connection from database-connection.php
        global $connection;
        #SQL Query for procedure purchase_delete
        $sqlQuery = "CALL purchase_delete(:p_purchase_uuid)";
        #Preparing the statement for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #binding the paramters of the procedure with data
        $PDOStatement->bindParam(':p_purchase_uuid', $purchaseUUID);
        #Executing the SQL Query
        $PDOStatement->execute();
        
        return true;
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
    }
}

