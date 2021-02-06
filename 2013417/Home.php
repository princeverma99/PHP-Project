<?php
    #including the PHPFunctions file into the webpage
    include_once 'PHP Functions/PHPFunctions.php';
    pageHeader("Home");  #Calling the pageHeader() and passing the title parameter
    navigationMenu();   #calling the Navigation Menu
    shuffle($products); #shuffling the order array of products
    ?>
<!--Displaying the information about the Website -->
<h1 class="info">Supreme Fitness is the distributer of Fitness Equipment. We sell best-in-class exercise machines for the home and for a wide variety of commercial facilities</h1>
<?php
    if($products[0] == PRODUCT_CYCLE)   #after shuffling if the product cycle is at array position 0, then class will be product_cycle
    {
        echo '<br><img src="'.$products[0].'" class="product_cycle"></img>';
    }
    else    #otherwise the class will be product
    {
        echo '<br><img src="'.$products[0].'" class="product"></img>';
    }
    ?>
<div class="cheatSheet">
    <h3><a href="<?php echo CHEAT_SHEET;?>" download>Click to Download Cheat Sheet</a></h3>
</div>
<?php
    pageFooter();   #calling the pageFooter() for HTML closing Tags
?>


