<?php  
/*
 * Revision History
 * Prince Verma(2013417)    06-12-2020  created class product and declared all the fields and implemented get, set and Load functions
 * Prince Verma(2013417)    09-12-2020  Added field product_uuid and changed functions accordingly 
 * Prince Verma(2013417)    11-12-2020  added save() and delete()
 */
#including the PHPFunctions file into the webpage
include_once 'PHP Functions/PHPFunctions.php';
#including the database connection file
include_once DATABASE_CONNECTION_FILE;

class product
{
    #Fields of class product
    private $product_uuid = '';
    private $product_code = '';
    private $description = '';
    private $price = 0.0;
    private $cost_price = 0.0;
    
    #Constructor of class product with optional parameters
    public function __construct($product_uuid = '', $product_code='', $description = '', $price = '', $cost_price = '') 
    {
        $this->product_uuid = $product_uuid;
        $this->product_code = $product_code;
        $this->description = $description;
        $this->price = $price;
        $this->cost_price = $cost_price;   
    }
    
    #Function to get productUUID
    function getProductUUID()
    {
        return $this->product_uuid;
    }
    
    #Function to get ProductCode
    function getProductCode()
    {
        return $this->product_code;
    }
    #Function to set ProductCode with value passed through parameter
    function setProductCode($newProductCode)
    {
        $this->product_code = $newProductCode;
    }
    
    #Funciton to get Description of the product
    function getDescription()
    {
        return $this->description;
    }
    #Function to set Description with the data passed via parameter
    function setDescription($newDescription)
    {
        $this->description = $newDescription;
    }
    
    #Function to get the price field
    function getPrice()
    {
        return $this->price;
    }
    #Function to set the price field with value passed
    function setPrice($newPrice)
    {
        $this->price = $newPrice;
    }
    
    #Function to get the cost price
    function getCostPrice()
    {
        return $this->cost_price;
    }
    #Function to set the cost price with value passed via parameter
    function setCostPrice($newCostPrice)
    {
        $this->cost_price = $newCostPrice;
    }
    
    #Function to load the data of a particular product based on productUUID
    public function Load($productUUID)
    {
        #Using connection string
        global $connection;
        #SQL Query to run procedure product_load
        $sqlQuery = "CALL product_load(:p_product_uuid)";
        #Preparing the statement for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #Binding the parameters of the procedure with the value
        $PDOStatement->bindParam(':p_product_uuid', $productUUID);
        #Executing the procedure
        $PDOStatement->execute();
        #Fetching the data from the procedure
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            #Assigning the data to the fields with the data fetched from database
            $this->product_uuid = $row['product_uuid'];
            $this->product_code = $row['product_code'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->cost_price = $row['cost_price'];
            return true;
        }
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
    }
    
    public function Save()
    {
        #using $connection from database-connection.php
        global $connection;
        #If there is no productUUID of the product, then it will insert a new product in the database
        if($this->product_uuid == '')
        {
            #SQL Query to run procedure product_insert with paramteres
            $sqlQuery = "CALL product_insert(:p_product_code, :p_description, :p_price, :p_cost_price)";
            #Preparing the SQL Query for execution
            $PDOStatement = $connection->prepare($sqlQuery);
            #binding the parameters of the procedure
            $PDOStatement->bindParam(':p_product_code', $this->product_code);
            $PDOStatement->bindParam(':p_description', $this->description);
            $PDOStatement->bindParam(':p_price', $this->price);
            $PDOStatement->bindParam(':p_cost_price', $this->cost_price);
            #executing the SQL Query will return the rows affected
            $affectedRows = $PDOStatement->execute(); 
            #If the rows of the table are affected(means inserted) then return true otherwise false
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
        #if the product has productUUID, then it will update the existing data
        else
        {
            #SQL Query to run procedure product_update with paramteres
            $sqlQuery = "CALL product_update(:p_product_uuid, :p_product_code, :p_description, :p_price, :p_cost_price)";
            #Preparing the statement for execution
            $PDOStatement = $connection->prepare($sqlQuery);
            #binding the parameters of the procedure
            $PDOStatement->bindParam(':p_product_uuid', $this->product_uuid);
            $PDOStatement->bindParam(':p_product_code', $this->product_code);
            $PDOStatement->bindParam(':p_description', $this->description);
            $PDOStatement->bindParam(':p_price', $this->price);
            $PDOStatement->bindParam(':p_cost_price', $this->cost_price);
            #executing the procedure
            $PDOStatement->execute();   
            return true;
            #Closing the cursor to enable other statements to be executed properly
            $PDOStatement->closeCursor();
        }
    }
    
    public function Delete()
    {
        #Using connection string from database-connection.php
        global $connection;
        #SQL Query to run procedure product_insert with paramteres
        $sqlQuery = "CALL product_delete(:p_product_uuid)";
        #Preparing the PDOStatement for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #binding the parameters of the procedure
        $PDOStatement->bindParam(':product_uuid', $this->product_uuid);
        #Deleting the data from table will return the rows affected
        $affectedRows = $PDOStatement->execute();
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
        #returing the number of affected rows
        return $affectedRows;
    }
    
}
