<?php

// base class with member properties and methods
class Base 
{
    const ID_KEY = "id";
    const CREATED_KEY = "created_at";
    const UPDATES_KEY = "updated_at";

    var $id;
    var $createdAt;
    var $updatedAt;

    function __construct($id, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}

?>