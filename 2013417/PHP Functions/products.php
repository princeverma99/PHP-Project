<?php
/*
 * Revision History
 * Prince Verma(2013417)    06-12-2020  create class products
 * Prince Verma(2013417)    09-12-2020  Added the parameter product_uuid while creating the object of class product
 */
#including the PHPFunctions file into the webpage
include_once 'PHP Functions/PHPFunctions.php';
#including all the required files
include_once DATABASE_CONNECTION_FILE;
include_once COLLECTION_FILE;
include_once CLASS_PRODUCT;

#class product is inheriting class collections
class products extends collection
{
    #constructor of class product
    function __construct()
    {
        #using connection string from database-connection.php
        global $connection;
        #SQL Query to run procedure products_select
        $sqlQuery = "CALL products_select()";
        #Preparing the PDO Statement for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #Executing the SQL Query
        $PDOStatement->execute();  
        #Fetching the data from the procedure using associative array
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            #creating object of class product and passing the values to the paramters
            $product = new product($row['product_uuid'], $row['product_code'], $row['description'], $row['price'], $row['cost_price']);
            #calling add() of class collection to add every product data with productUUID and object of each product
            $this->add($row['product_uuid'], $product);
        }
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
    }
}


