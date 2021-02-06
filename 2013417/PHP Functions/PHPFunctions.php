 <?php
#Creating constants
define("FOLDER_CSS","CSS/");
define("CSS_FILE",FOLDER_CSS."style.css"); 
define("FOLDER_IMAGES","Images/");
define("LOGO",FOLDER_IMAGES."logo.png");
define("HOME_PAGE","Home.php"); 
define("BUY_PAGE","Buy.php");
define("REGISTER_PAGE","Register.php");
define("ACCOUNT_PAGE", "Account.php");
define("PURCHASES_PAGE", "purchases.php");
define("PRODUCT_EX_BIKE",FOLDER_IMAGES."Excerscise Bike.jpeg");
define("PRODUCT_TREDMILL",FOLDER_IMAGES."Tredmill.jpg");
define("PRODUCT_ELLIPTICAL",FOLDER_IMAGES."Elliptical.jpg");
define("PRODUCT_CYCLE",FOLDER_IMAGES."Cycle.jpg");
define("PRODUCT_ROWERS",FOLDER_IMAGES."Rowers.jpg");
define("PURCHASES_FILE","purchases.txt");
define("CHEAT_SHEET","Cheat Sheet.txt");
define("COLLECTION_FILE", "collection.php");
define("FOLDER_PHP_FUNCTIONS", "PHP Functions/");
define("FOLDER_ERRORS_EXCEPTIONS","Errors and Exceptions/");
define("ERROR_FILE",FOLDER_ERRORS_EXCEPTIONS."Errors.txt");
define("EXCEPTION_FILE",FOLDER_ERRORS_EXCEPTIONS."Exceptions.txt");
define("DATABASE_CONNECTION_FILE", FOLDER_PHP_FUNCTIONS."database-connection.php");
define("CLASS_CUSTOMER", FOLDER_PHP_FUNCTIONS."customer.php");
define("CLASS_CUSTOMERS", FOLDER_PHP_FUNCTIONS."customers.php");
define("CLASS_PRODUCT", FOLDER_PHP_FUNCTIONS."product.php");
define("CLASS_PRODUCTS", FOLDER_PHP_FUNCTIONS."products.php");
define("CLASS_PURCHASE", FOLDER_PHP_FUNCTIONS."purchase.php");
define("CLASS_PURCHASES", FOLDER_PHP_FUNCTIONS."purchases.php");
define("FOLDER_JAVASCRIPT", "JavaScript/");
define("AJAX_FILE", FOLDER_JAVASCRIPT."ajax.js");

#creating array of images of products which are to be shuffled and displayed in Home.php
$products = array(PRODUCT_EX_BIKE, PRODUCT_TREDMILL, PRODUCT_ELLIPTICAL, PRODUCT_CYCLE, PRODUCT_ROWERS);

#function for Header of HTML document
function pageHeader($title)
    {
    //page headers required to prevent page caching, so when user will reload the page, they will always get the latest version of file.
    header('Expires: Thu, 01, 1994 10:00:00 GMT');
    header('Cache-Control: no-cache');
    header('pragma: no-cache');
    //Forcing the website to use HTTPS port.
    if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!="on")
    {
        header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]);
    }
    //Calling the ErrorandExceptionHandling() for proving Error and Exception Handling to each and every page
    ErrorandExceptionHandling();
    ?>
    <!DOCTYPE>
    <html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title;?></title> <!-- Parameter $title will display the title of the page -->
        <link rel="stylesheet" type="text/css" href ="<?php echo CSS_FILE;?>">  <!--Linking the CSS with the page-->
        <script lang="javascript" type="text/javascript" src="<?php echo AJAX_FILE;?>"></script><!--Adding the JavaScript to the pages-->
    </head>
    <body>
    <?php
    }
    #function for end of HTML document
    function pageFooter()
    {
        copyright();
    ?>
    </body>
    </html>   
    <?php
    }
    #function to display the copyright
    function copyright()
    {
        echo '<br><p class = "copyright">Copyright Prince Verma (2013417) '.date('Y').'</p>';
    }
    #function to display the logo
    function displayLogo()
    {
        echo '<a href = "'.HOME_PAGE.'"><img src = "'.LOGO.'" height = "150px" width = "230px" class="logo"></a>';
    }
    #function to create the navigation menu which contains the logo and all the links
    function navigationMenu()
    {   
        echo '<div class = "navMenu">';
        displayLogo();
        echo '<ul>';
        echo '<li><a href = "'.HOME_PAGE.'">Home</a></li>'; 
        echo '<li><a href = "'.BUY_PAGE.'">Buy</a></li>';
        echo '<li><a href = "'.PURCHASES_PAGE.'">Purchases</a></li>';
        echo '<li><a href = "'.ACCOUNT_PAGE.'">Account</a></li>';
        echo '</ul>';
        echo '</div>';
    }
    #function to display the login form if the user is not logged in before performing any operation
    function Login()
    {   
        include_once DATABASE_CONNECTION_FILE;
        include_once CLASS_CUSTOMER;
        #creating the object of class customer
        $customer = new customer();
        #declaring variables
        $usernameErrorMessage = '';
        $passwordErrorMessage = '';
        if(isset($_POST['submit']))
        {
            #using htmlspecialchars() to prevent SQL Injection
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            if(mb_strlen($username) == 0)   #Validating that the username is not empty
            {
                $usernameErrorMessage = "Username cannot be empty";
            }
            if(mb_strlen($password) == 0)   #Validating that the password is not empty
            {
                $passwordErrorMessage = "Password cannot be empty";
            }
            
            #If the username and password is not empty, then it will check the username and password entered
            if($usernameErrorMessage=='' && $passwordErrorMessage=='')
            {
                #declaring variable
                $dbPassword = '';
                #using the variable $connection from database-connection.php
                global $connection;

                #SQL Query for running the procedure get_password(:p_username) to retrieve the password from username
                $sqlQuery = "CALL get_password(:p_username)";
                #Preparing the SQL Query
                $PDOStatement = $connection->prepare($sqlQuery);
                #Binding the Parameters which are inputs of the procedure
                $PDOStatement->bindParam(':p_username', $username);
                #Executing the SQL Query
                $PDOStatement->execute();
                #Fetching the data from the Executed SQL Query
                while($row=$PDOStatement->fetch())
                {
                    $dbPassword = $row['password'];
                }
                #Closing Cursor for $PDOStatement to allow other SQL Queries to be executed properly
                $PDOStatement->closeCursor();
                #using password_verify to check that the password entered by the user is same as password retrieved from database which is of 255 Characters
                #password_verify compares the string with the hashed string and return true if matches, else returns false
                if(password_verify($password, $dbPassword))
                {
                    #calling the Login($username, $password) from class customer
                    if($customer->Login($username, $dbPassword))
                    {
                        #Setting SESSION of user with the customerUUID
                        $_SESSION['user'] = $customer->getCustomerUUID();
                        #Refreshing the page
                        header('Location: '. $_SERVER['REQUEST_URI']);
                    }
                }
                else     
                {
                    #if the username and password is incorrect then it will unset the SESSION of user and display message
                    unset($_SESSION['user']);
                    echo "<h3 class = 'incorrectError'>Username or Password Incorrect</h3><br>";
                }
            }   
        }
        ?>
        <!--Login Form-->
        <h3 style="text-align: center">Please Login to Continue</h3>
        <h4 class="required">* = required</h4>
        <form method="POST">
        <p>
            <label>Username: <span class="required">*</label>
            <input type="text" name="username"><span class="validation"><?php echo $usernameErrorMessage; ?></span>
        </p>
        <p>
            <label>Password: <span class="required">*</label>
            <input type="password" name="password"><span class="validation"><?php echo $passwordErrorMessage; ?></span>
        </p>
        <p>
            <input type="submit" name="submit" value="Login" class="button">
        </p>
        </form>
        <p class="loginRegister">Need a User Account? <a href="<?php echo REGISTER_PAGE; ?>">Register</a></p>
    <?php
    }
    #Function to Display the username and Logout form
    function Logout()
    {
        include_once CLASS_CUSTOMER;
        #creating the object of class customer
        $customer = new customer();
        #Loading the data of the SESSION user to display the firstname and lastname
        $customer->Load($_SESSION['user']);
        echo "<h3 style='text-align: center;'>Welcome ".$customer->getFirstname()." ".$customer->getLastname()."</h3>";
        #If the user clicks on logout button
        if(isset($_POST['logout']))
        {
            #the SESSION user will be unset and the user needs to login again to perform functions
            unset($_SESSION['user']);
            #Reloading the page
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
        ?>
        <!--Logout Form-->
        <form method="POST">
            <p>
                <input type="submit" name="logout" value="Logout" class="button">
            </p>
        </form>
        <?php
    }
    #Function for Error and Exception Handling
    function ErrorandExceptionHandling()
    {
        error_reporting(0); #Prevents Error to be Displayed to the user
        #Function to manage errors
        function ManageErrors($erroNumber, $errorString, $errorFile, $errorLine, $errorContext)
        {  
            #$debug should be true during development, to display the error
            #$debug should be false to prevent displaying errors to user
            $debug = false;
            if($debug)
            {
                #Displaying the Error
                echo "Error : ".$errorString."<br>"; 
                echo "FileName : ".$errorFile."<br>";
                echo "FileLine : ".$errorLine."<br>";
            }
            #Setting the default timezone 
            date_default_timezone_set('America/Toronto');
            $dateTime = date("Y-m-d G:i:s:v");
            $error = array($errorString, $errorFile, $errorLine,$dateTime);
            #Writing the errors to a file
            file_put_contents(ERROR_FILE, json_encode($error)."\r\n",FILE_APPEND);
            #Displaying the error message
            echo "<h3 class ='ErrorsandExceptions'>PHP ended because of an error</h3>";
            #Displaying the page Footer
            pageFooter();
            #die() will end PHP
            die();
        }
        #Function to manage exceptions
        function ManageExceptions($exception)
        {
            #$debug should be true during development, to display the exceptions
            #$debug should be false to prevent displaying exceptions to user
            $debug = false;
            if($debug)
            {
                #Displaying Exceptions
                echo "Error : ".$exception->getMessage()."<br>"; 
                echo "FileName : ".$exception->getFile()."<br>";
                echo "FileLine : ".$exception->getLine()."<br>";
            }
            #Setting the default timezone
            date_default_timezone_set('America/Toronto');
            $dateTime = date("Y-m-d G:i:s:v");
            $exceptionArray = array($exception->getMessage(), $exception->getFile(), $exception->getLine(),$dateTime);
            #Writing the exceptions to a file
            file_put_contents(EXCEPTION_FILE, json_encode($exceptionArray)."\r\n",FILE_APPEND);
            #Displaying the exception message
            echo "<h3 class ='ErrorsandExceptions'>PHP ended because of an exception</h3>";
            #Displaying the page footer
            pageFooter();
            #Ending the PHP
            die();
        }
        #using set_error_handler() to set the defined error handler function
        set_error_handler("ManageErrors");
        #using set_exception_handler() to set the defined exception handler function
        set_exception_handler("ManageExceptions");
    }