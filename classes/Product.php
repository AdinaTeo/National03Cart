<?php

class Product extends BaseClass
{
    public $name;
    public $price;
    public $categoryId;
    public $discount;
    public $image;
    public $code;
    public $reviewNumber;

    public static function getTableName()
    {
       return 'products';
    }


}