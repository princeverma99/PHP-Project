<?php
    /*
     * Revision History
     * Prince Verma(2013417)    03-12-2020  Created database-connection.php and added connection string
     */
    #Connection String 
    $connection = new PDO('mysql:host=localhost;dbname=database-2013417', 'user-2013417', '1234');
    #Setting attributes for errors and exceptions
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    

