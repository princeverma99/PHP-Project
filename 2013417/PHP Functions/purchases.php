<?php
/*
 * Revision History
 * Prince Verma(2013417)    06-12-2020  Created class purchases
 * Prince Verma(2013417)    09-12-2020  Modified the parameter product_code to product_uuid while creating the object of class purchase
 * Prince Verma(2013417)    11-12-2020  Added filterPurchases() and modified __construct()
 */
#including the PHPFunctions file into the webpage
include_once 'PHP Functions/PHPFunctions.php';
#including all the required files
include_once DATABASE_CONNECTION_FILE;
include_once COLLECTION_FILE;
include_once CLASS_PURCHASE;

#class purchases is inheriting class collection
class purchases extends collection
{
    #constructor of class purchases
    function __construct()
    {
        #using connection string
        global $connection;
        #query to run procedure purchases_select
        $sqlQuery = "CALL purchases_select()";
        #preparing the PDOStatement for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #executing the SQL Query
        $PDOStatement->execute();
        #fetching the data from the procedure using associative array
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            #creating object of class purchase and passing the values to the paramters
            $purchase = new purchase($row['purchase_uuid'], $row['customer_uuid'] ,$row['product_uuid'], $row['quantity'], $row['comments'], $row['subtotal'], $row['taxes'], $row['grandtotal']);
            #adding each data row to the collection
            $this->add($row['purchase_uuid'], $purchase);
        }
        #closing the cursor to allow other statements to be executed
        $PDOStatement->closeCursor();
    }
    
    #function to get the purchases data from the database based on search date and customerUUID
    function filterPurchases($searchedDate, $customer_uuid)
    {
        #using connection string from database-connection.php
        global $connection;
        #SQL Query to run procedure purchases_filter with parameters
        $sqlQuery = "CALL purchases_filter(:p_searched_date, :p_customer_uuid)";
        #Preparing the sql query for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #binding the parameters of the procedure
        $PDOStatement->bindParam(':p_searched_date', $searchedDate);
        $PDOStatement->bindParam(':p_customer_uuid', $customer_uuid);
        #executing the procedure
        $PDOStatement->execute();
        #fetching the data from procedure
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            #creating object of class purchase and passing the data to parameters
            $purchase = new purchase($row['purchase_uuid'],$customer_uuid ,$row['product_uuid'], $row['quantity'], $row['comments'], $row['subtotal'], $row['taxes'], $row['grandtotal']);
            #adding each data row to the collection
            $this->add($row['purchase_uuid'], $purchase);
        }
        #closing the cursor to enable other statements to be executed
        $PDOStatement->closeCursor();
    }
}

