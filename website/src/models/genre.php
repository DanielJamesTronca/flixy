<?php

include_once("base.php");

class Genre extends Base 
{
    const NAME_KEY = "name";

    const TABLE_NAME = "Genre";

    var $name;
 
    public function __set( $name, $value ) {
        switch ($name)
        {
            case self::NAME_KEY: 
                $this->name = $value;
                break;
            default: 
                parent::__set($name, $value);
                break;
        }
    }
 }

?>