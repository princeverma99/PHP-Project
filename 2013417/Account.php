 <?php
    /*
     * Revision History
     * Prince Verma(2013417)   03-12-2020   Created Account.php and added form
     * Prince Verma(2013417)   04-12-2020   Added functionality to the form and Completed Account.php
     */
    #including the PHPFunctions file into the webpage
    include_once 'PHP Functions/PHPFunctions.php';
    #including the customer class
    include_once CLASS_CUSTOMER;
    #Calling pageHeader() and passing the title of the page
    pageHeader("Account");
    #calling navigationMenu() to show the menu
    navigationMenu();
    #session_start() to start or resume existing session
    session_start(); 
    
    #Declaring variables
    $firstname = '';
    $lastname = '';
    $address = '';
    $city = '';
    $province = '';
    $postalcode = '';
    $username = '';
    $password = '';
    
    #Declaring error variables
    $firstnameErrorMessage = '';
    $lastnameErrorMessage = '';
    $addressErrorMessage = '';
    $cityErrorMessage = '';
    $provinceErrorMessage = '';
    $postalcodeErrorMessage = '';
    $usernameErrorMessage = '';
    $passwordErrorMessage = '';
    
    #if the session variable - user is set with the customerUUID then the user will be able to perform functions
    if(isset($_SESSION['user']))
    {
        #creating the object of class customer
        $customer = new customer();
        #Loading the data of the customer based on customerUUID
        if($customer->Load($_SESSION['user']))
        {
            #assigning the data to the variables
            $firstname = $customer->getFirstname();
            $lastname = $customer->getLastname();
            $address = $customer->getAddress();
            $city = $customer->getCity();
            $province = $customer->getProvince();
            $postalcode = $customer->getPostalcode();
            $username = $customer->getUsername();
        }
        #If the $customer->Load() returns false, message will be displayed
        else
        {
            echo "<h3 class='updateInfo'>Error Occured, Please try again</h3>";
        }
    }
    #if the user is not logged-in means session variable - user not set it will show Login form
    else
    {
        #Display the login form
        Login();
        #Display page footer
        pageFooter();
        #End the program
        die();
    }
    #when user clicks on the submit button
    if(isset($_POST['submit']))
    {
        #using htmlspecialchars() to prevent SQL Injection
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);
        $address = htmlspecialchars($_POST['address']);
        $city = htmlspecialchars($_POST['city']);
        $province = htmlspecialchars($_POST['province']);
        $postalcode = htmlspecialchars($_POST['postalcode']);
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        
        #Validating and setting each field of class customer
        #If data entered for a particular field is not valid then it will display particular error message
        $firstnameErrorMessage = $customer->setFirstname($firstname);
        $lastnameErrorMessage = $customer->setLastname($lastname);
        $addressErrorMessage = $customer->setAddress($address);
        $cityErrorMessage = $customer->setCity($city);
        $provinceErrorMessage = $customer->setProvince($province);
        $postalcodeErrorMessage = $customer->setPostalcode($postalcode);
        $usernameErrorMessage = $customer->setUsername($username);
        $passwordErrorMessage = $customer->setPassword($password);
        
        #Checking that the data entered by the user does not contain any error
        if($firstnameErrorMessage == '' && $lastnameErrorMessage == '' && $addressErrorMessage == '' && $cityErrorMessage == '' && $provinceErrorMessage == '' && $postalcodeErrorMessage == '' && $usernameErrorMessage == '' && $passwordErrorMessage == '')
        {
            #calling Save() to save the data entered by the user
            if($customer->Save())
            {
                #After saving, Displaying the updated data to the user
                $firstname = $customer->getFirstname();
                $lastname = $customer->getLastname();
                $address = $customer->getAddress();
                $city = $customer->getCity();
                $province = $customer->getProvince();
                $postalcode = $customer->getPostalcode();
                $username = $customer->getUsername();
                $password = '';
                echo "<h3 class='updateInfo'>Data Saved Successfully</h3>";
            }
            #if the data is not saved, it will show error message
            else
            {
                echo "<h3 class='updateInfo'>Data was not Saved due to an Error</h3>";
            }
        }
    }
    
?>
<!--Account Update Form-->
<h4 class="required">* = required</h4>
<form method="POST">
        <p>
            <label>Firstname:<span class="required">*</span></label>
            <input type="text" name ="firstname" value="<?php echo $firstname; ?>"><span class="validation"><?php echo $firstnameErrorMessage; ?></span>
        </p>
        <p>
            <label>Lastname:<span class="required">*</span></label>
            <input type="text" name ="lastname" value="<?php echo $lastname; ?>"><span class="validation"><?php echo $lastnameErrorMessage; ?></span>
        </p>
        <p>
            <label>Address:<span class="required">*</span></label>
            <input type="text" name ="address" value="<?php echo $address; ?>"><span class="validation"><?php echo $addressErrorMessage; ?></span>
        </p>
        <p>
            <label>City:<span class="required">*</span></label>
            <input type="text" name ="city" value="<?php echo $city; ?>"><span class="validation"><?php echo $cityErrorMessage; ?></span>
        </p>
        <p>
            <label>Province:<span class="required">*</span></label>
            <input type="text" name ="province" value="<?php echo $province; ?>"><span class="validation"><?php echo $provinceErrorMessage; ?></span>
        </p>
        <p>
            <label>Postal Code:<span class="required">*</span></label>
            <input type="text" name ="postalcode" value="<?php echo $postalcode; ?>"><span class="validation"><?php echo $postalcodeErrorMessage; ?></span>
        </p>
        <p>
            <label>Username:<span class="required">*</span></label>
            <input type="text" name ="username" value="<?php echo $username; ?>"><span class="validation"><?php echo $usernameErrorMessage; ?></span>
        </p>
        <p>
            <label>Password:<span class="required">*</span></label>
            <input type="password" name ="password"><span class="validation"><?php echo $passwordErrorMessage; ?></span>
        </p>
        <p>
            <input type="submit" value="Update Info" name="submit" class="button"/>
        </p>
    </form>
<?php
    #Displaying the logout form to the logged user
    Logout();
    #Displaying page footer
    pageFooter();
?>
