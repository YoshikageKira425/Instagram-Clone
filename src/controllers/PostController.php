<?php

require __DIR__ . "/../model/Post.php";

class PostController
{
    private $postModel;

    public function __construct()
    {
        $postModel = new Post();
    }
}