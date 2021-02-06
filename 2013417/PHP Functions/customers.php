<?php
/*
 * Revision History
 * Prince Verma(2013417)    03-12-2020  Created class customers
 */
#including the PHPFunctions file into the webpage
include_once 'PHP Functions/PHPFunctions.php';
#including all the required files
include_once DATABASE_CONNECTION_FILE;
include_once COLLECTION_FILE;
include_once CLASS_CUSTOMER;

#class customers is inheriting class collection
class customers extends collection
{
    #constructor for class customers which will be called when the objects will be created
    function __construct()
    {
        #using connection string from database-connection.php
        global $connection;
        #SQL Query to run procedure customers_select
        $sqlQuery = "CALL customers_select()";
        #Preparing the SQL Query for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #Executing the SQL Query
        $PDOStatement->execute();
        #Fetching the data from the procedure using associative array
        while($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            #creating a new object of class customer and passing the values to the paramters which will initialize the field of class customer
            $customer = new customer($row['customer_uuid'],$row['firstname'], $row['lastname'], $row['address'], $row['city'], $row[province], $row['postalcode'], $row['username'], $row['password']);
            #Adding each data row to the class collection
            $this->add($row['customer_uuid'], $customer);
        }
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
    }
}


