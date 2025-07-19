<?php
declare(strict_types=1);

require_once __DIR__ . "/../model/User.php";

final class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function handleFollowAction(string $action, int $follow_by, int $follow_to): void
    {
        if ($action == "followed")
            $this->userModel->followSomeone($follow_by, $follow_to);
        else if ($action == "unfollowed")
            $this->userModel->unFollowSomeone($follow_by, $follow_to);

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    public function isFollowedToSomeone(int $follow_by, int $follow_to): bool
    {
        return $this->userModel->isFollowedToSomeone($follow_by, $follow_to);
    }

    public function getFollowerCount(int $id): int
    {
        return count($this->userModel->getFollowedTo($id));
    }

    public function getFollowingCount(int $id): int
    {
        return count($this->userModel->getFollowedBy($id));
    }

    public function updateAccountInfo(array $user, array $data): void
    {
        $user["username"] = $data["username"];

        $this->userModel->updatedUser($user["id"], $user);

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }

    public function updateSecurity(array $user, array $data): void
    {
        if (!password_verify($data["currentPassword"], $user["password"])) {
            $_SESSION["security_error"] = "The current password isnt corrent.";
            return;
        }

        if (strlen($data["newPassword"]) < 6)

        $password_hash = password_hash($data["newPassword"], PASSWORD_DEFAULT);
        $user["password"] = $password_hash;

        $this->userModel->updatedUser($user["id"], $user);

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}
