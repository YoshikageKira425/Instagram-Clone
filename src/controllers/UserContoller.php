<?php

require_once __DIR__ . "/../model/User.php";

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function handleFollowAction($action, $follow_by, $follow_to)
    {
        if ($action == "followed")
            $this->userModel->followSomeone($follow_by, $follow_to);
        else if ($action == "unfollowed")
            $this->userModel->unFollowSomeone($follow_by, $follow_to);

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    public function isFollowedToSomeone($follow_by, $follow_to)
    {
        return $this->userModel->isFollowedToSomeone($follow_by, $follow_to);
    }

    public function getFollowerCount($id) 
    {
        return count($this->userModel->getFollowedTo($id));
    }
    public function getFollowingCount($id) 
    {
        return count($this->userModel->getFollowedBy($id));
    }
}
