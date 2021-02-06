<?php
/*
 * Revision History
 * Prince Verma(2013417)    03-12-2020  Created class customer, declared all the fields and implemented get, set, Load, Save, Delete functions    
 * Prince Verma(2013417)    04-12-2020  Modified Load() and created Login()
 */
#including the PHPFunctions file into the webpage
include_once 'PHP Functions/PHPFunctions.php';
#including the database connection file
include_once DATABASE_CONNECTION_FILE;
#Defining Constants
define("FIRSTNAME_MAX_LENGTH",20);
define("LASTNAME_MAX_LENGTH",20);
define("ADDRESS_MAX_LENGTH", 25);
define("CITY_MAX_LENGTH", 25);
define("PROVINCE_MAX_LENGTH", 25);
define("POSTALCODE_MAX_LENGTH", 7);
define("USERNAME_MAX_LENGTH", 12);
define("PASSWORD_MAX_LENGTH",30);

class customer
{
    #Fields of class customer
    private $customer_uuid = '';
    private $firstname = '';
    private $lastname = '';
    private $address = '';
    private $city = '';
    private $province = '';
    private $postalcode = '';
    private $username = '';
    private $password = '';

    #Constructor of class customer with optional parameters
    public function __construct($customer_uuid = '', $firstname = '', $lastname = '', $address = '', $city = '', $province = '', $postalcode = '', $username = '', $password = '') 
    {
        $this->customer_uuid = $customer_uuid;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->address = $address;
        $this->city = $city;
        $this->province = $province;
        $this->postalcode = $postalcode;
        $this->username = $username;
        $this->password = $password;
    }
    
    #Function to get customerUUID
    function getCustomerUUID()
    {
        return $this->customer_uuid;
    }
        
    #Function to get first name
    function getFirstname()
    {
        return $this->firstname;
    }
    #Function to set first name when the data is validated
    function setFirstname($newFirstname)
    {
        if(mb_strlen($newFirstname) > FIRSTNAME_MAX_LENGTH) #checking that the length of firstname data is not more than 20 characters
        {
            return "First Name cannot contain more than ".FIRSTNAME_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newFirstname) == 0)  #checking that the firstname data is not empty
        {
            return "First Name cannot be empty";
        }
        else
        {
            #When the data is validating assigning the data to field firstname
            $this->firstname = $newFirstname;
            return '';
        }
    }
    
    #Function to get last name
    function getLastname()
    {
        return $this->lastname;
    }
    #function to set lastname field with data after validation
    function setLastname($newLastname)
    {
        if(mb_strlen($newLastname) > LASTNAME_MAX_LENGTH)   #Validating that the lastname data is not more than 20 characters
        {
            return "Last Name cannot contain more than ".LASTNAME_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newLastname) == 0)   #Validating that the lastname data is not empty
        {
            return "Last Name cannot be empty";
        }
        else
        {   
            #When data is validated assigning that data to field lastname
            $this->lastname = $newLastname;
            return '';
        }
    }
    
    #function to get the address
    function getAddress()
    {
        return $this->address;
    }
    #function to set address by validating data
    function setAddress($newAddress)
    {
        if(mb_strlen($newAddress) > ADDRESS_MAX_LENGTH) #Checking whether address data is not more than 25 characters
        {
            return "Address cannot contain more than ".ADDRESS_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newAddress) == 0)    #Checking that the address data is not empty
        {
            return "Address cannot be empty";
        }
        else
        {
            #Assigning the data to address field upon validation
            $this->address = $newAddress;
            return '';
        }
    }
    
    #function to return city
    function getCity()
    {
        return $this->city;
    }
    #function to set city field with data upon validation
    function setCity($newCity)
    {
        if(mb_strlen($newCity) > CITY_MAX_LENGTH)   #If the length of city is more than 25 characters then it will return error message
        {
            return "City cannot contain more than ".CITY_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newCity) == 0)   #if the city data is empty, erros message will be returned
        {
            return "City cannot be empty";
        }
        else
        {
            #Assigning the data to city field on validation
            $this->city = $newCity;
            return '';
        }
    }
    
    #function to get Province field value
    function getProvince()
    {
        return $this->province;
    }
    #function to set Province field after Validating the data
    function setProvince($newProvince)
    {
        if(mb_strlen($newProvince) > PROVINCE_MAX_LENGTH)   #Checking that the province data is not more than 25 characters
        {
            return "Province cannot contain more than ".PROVINCE_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newProvince) == 0)   #checking that the province data is not empty
        {
            return "City cannot be empty";
        }
        else
        {
            #Assigning after validation
            $this->province = $newProvince;
            return '';
        }
    }
    
    #function to return postalcode
    function getPostalcode()
    {
        return $this->postalcode;
    }
    #function to set postalcode by validating data
    function setPostalcode($newPostalcode)
    {
        if(mb_strlen($newPostalcode) > POSTALCODE_MAX_LENGTH)   #Validating that the postalcode data is not more than 7 characters
        {
            return "Postal Code cannot contain more than ".POSTALCODE_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newPostalcode) == 0) #Validating that the postalcode is not empty
        {
            return "Postal Code cannot be empty";
        }
        else
        {
            #Assigning data on validation
            $this->postalcode = $newPostalcode;
            return '';
        }
    }
    
    #function to get username field
    function getUsername()
    {
        return $this->username;
    }
    #function to set username field
    function setUsername($newUsername)
    {
        if(mb_strlen($newUsername) > USERNAME_MAX_LENGTH)   #checking that the username data is not more than 12 characters
        {
            return "Username cannot contain more than ".USERNAME_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newUsername) == 0)   #checking that the username data is not empty
        {
            return "Username cannot be empty";
        }
        else
        {
            #Assigning the value to the username field after validation
            $this->username = $newUsername;
            return '';
        }
    }
    
    #function to get password field
    function getPassword()
    {
        return $this->password;
    }
    #funtion to set password field
    function setPassword($newPassword)
    {
        if(mb_strlen($newPassword) > PASSWORD_MAX_LENGTH)   #validating whether password data is not more than 30 characters.
        {
            return "Password cannot contain more than ".PASSWORD_MAX_LENGTH." characters";
        }
        else if(mb_strlen($newPassword) == 0)   #validating that the password data is not empty
        {
            return "Password cannot be empty";
        }
        else
        {
            #assigning password upon validation
            $this->password = $newPassword;
            return '';
        }
    }
    
    #function to Login using username and password
    public function Login($username, $password)
    {
        #using $connection from database-connection.php
        global $connection;
        
        #SQL Query to run procedure customer_login with paramteres
        $sqlQuery = "CALL customer_login(:p_username, :p_password)";
        
        #Preparing the SQL Query for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        
        #Binding the parameter of the procedure with the data
        $PDOStatement->bindParam(':p_username', $username);
        $PDOStatement->bindParam(':p_password', $password);
        
        #Executing the SQL Query
        $PDOStatement->execute();
        
        #Fetching the data from the procedure
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            $this->customer_uuid = $row['customer_uuid'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            return true;
        }
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
    }
    
    #Function to Load the data of a particular customer and assigning values to the fields
    public function Load($customer_uuid)
    {
        #using $connection from database-connection.php
        global $connection;
        
        #SQL Query for procedure customer_load with paramteres
        $sqlQuery = "CALL customer_load(:p_customer_uuid)";
        
        #Preparing the SQL Query for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        
        #binding the parameters of the procedure
        $PDOStatement->bindParam(':p_customer_uuid', $customer_uuid);
        
        #executing the SQL Query
        $PDOStatement->execute();
        
        #fetching the data from the procedure
        if($row = $PDOStatement->fetch(PDO::FETCH_ASSOC))
        {
            $this->customer_uuid = $row['customer_uuid'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->address = $row['address'];
            $this->city = $row['city'];
            $this->province = $row['province'];
            $this->postalcode = $row['postalcode'];
            $this->username = $row['username'];
            $this->password = $row['password'];
            return true;
        }
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
    }
    
    public function Save()
    {
        #using $connection from database-connection.php
        global $connection;
        if($this->customer_uuid == '')
        {
            #SQL Query to run procedure customer_insert with paramteres
            $sqlQuery = "CALL customer_insert(:p_firstname, :p_lastname, :p_address, :p_city, :p_province, :p_postalcode, :p_username, :p_password)";
            #Preparing the SQL Query for execution
            $PDOStatement = $connection->prepare($sqlQuery);
            #binding the parameters of the procedure
            $PDOStatement->bindParam(':p_firstname', $this->firstname);
            $PDOStatement->bindParam(':p_lastname', $this->lastname);
            $PDOStatement->bindParam(':p_address', $this->address);
            $PDOStatement->bindParam(':p_city', $this->city);
            $PDOStatement->bindParam(':p_province', $this->province);
            $PDOStatement->bindParam(':p_postalcode', $this->postalcode);
            $PDOStatement->bindParam(':p_username', $this->username);
            $hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $PDOStatement->bindParam(':p_password', $hashPassword);
            #executing the SQL Query, which returns the rows affected
            $affectedRows = $PDOStatement->execute(); 
            #if the rows are affected then return true else false
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
            #SQL Query to run procedure customer_update with paramteres
            $sqlQuery = "CALL customer_update(:p_customer_uuid, :p_firstname, :p_lastname, :p_address, :p_city, :p_province, :p_postalcode, :p_username, :p_password)";
            #Preparing the SQL Query for execution
            $PDOStatement = $connection->prepare($sqlQuery);
            #binding the parameters of the procedure
            $PDOStatement->bindParam(':p_customer_uuid', $this->customer_uuid);
            $PDOStatement->bindParam(':p_firstname', $this->firstname);
            $PDOStatement->bindParam(':p_lastname', $this->lastname);
            $PDOStatement->bindParam(':p_address', $this->address);
            $PDOStatement->bindParam(':p_city', $this->city);
            $PDOStatement->bindParam(':p_province', $this->province);
            $PDOStatement->bindParam(':p_postalcode', $this->postalcode);
            $PDOStatement->bindParam(':p_username', $this->username);
            $hashPassword = password_hash($this->password, PASSWORD_DEFAULT);
            $PDOStatement->bindParam(':p_password', $hashPassword);
            #executing the SQL Query
            $PDOStatement->execute();   
            return true;
            
            #Closing the cursor to enable other statements to be executed properly
            $PDOStatement->closeCursor();
        }
    }
    
    public function Delete()
    {
        #using $connection from database-connection.php
        global $connection;
        
        #SQL Query to run procedure customer_delete with paramteres
        $sqlQuery = "CALL customer_delete(:p_customer_uuid)";
        #Preparing the SQL Query for execution
        $PDOStatement = $connection->prepare($sqlQuery);
        #binding the parameters of the procedure
        $PDOStatement->bindParam(':p_customer_uuid', $this->customer_uuid);
        #executing the SQL Query which will return the number of rows affected
        $affectedRows = $PDOStatement->execute();
        #Closing the cursor to enable other statements to be executed properly
        $PDOStatement->closeCursor();
        return $affectedRows;
    }
    
}