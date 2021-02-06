<?php
    /*
     * Revision History
     * Prince Verma(2013417)    03-12-2020  created Register.php and added form and functionality
     */
    #including the PHPFunctions file into the webpage
    include_once ('PHP Functions/PHPFunctions.php');
    #including class customer
    include_once CLASS_CUSTOMER;
    pageHeader("Register"); #calling pageHeader() and passsing the title parameter
    navigationMenu();   #Displaying the navigation menu
    $customer = new customer(); #creating the object of class customer
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
                #After saving, clearing the form
                $firstname = '';
                $lastname = '';
                $address = '';
                $city = '';
                $province = '';
                $postalcode = '';
                $username = '';
                $password = '';
                #Refreshing the page
                header('Location: '.BUY_PAGE);
            }
            #if the data is not saved, it will show error message
            else
            {
                echo "<h3 class='registerInfo'>Data was not Saved due to an Error</h3>";
            }
        }
    }
     
?>
<!--Register Form-->
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
            <input type="submit" value="save info" name="submit" class="button"/>
            <input type="reset" value="clear data" class="button"/>
        </p>
    </form>
<?php
    #calling pageFooter() for HTML closing Tags and display footer
    pageFooter();
?>
