<?php
/*
 * Revision History
 * Prince Verma(2013417)    03-12-2020  Created collection.php and class collection and added fields and methods of the class
 */
class collection
{
    #field of class collection
    public $items = array();
    #default constructor
    public function __construct() {

    }
    #function to add the data to array with the primary key and object of particular class
    public function add($primary_key, $item)
    {
        $this->items[$primary_key] = $item;
    }
    #function to remove the data from the array using primary key
    public function remove($primary_key)
    {
        if(isset($this->items[$primary_key]))
        {
            unset($this->items[$primary_key]);
        }
    }
    #function to get the data based on primary key
    public function get($primary_key)
    {
        if(isset($this->items[$primary_key]))
        {
            return $this->items[$primary_key];
        }
    }
    #function to return the number of items in the array
    public function count()
    {
        return count($this->items);
    }
}