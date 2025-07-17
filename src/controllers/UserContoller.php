<?php

require __DIR__ . "/../model/User.php";

class UserController
{
    private $userModel;

    public function __construct()
    {
        $userModel = new User();     
    }

    
}