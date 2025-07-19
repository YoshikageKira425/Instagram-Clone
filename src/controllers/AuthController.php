<?php
declare(strict_types=1);

require_once __DIR__ . "/../model/User.php";

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function logIn(array $data):void
    {
        if (empty($data) || empty($data["email"]) || empty($data["password"])) {
            $_SESSION["error"] = "All fields are required.";
            return;
        }

        $user = $this->userModel->findByEmail($data["email"]);

        if (empty($user)) {
            $_SESSION["error"] = "That email doesnt exits.";
            return;
        }

        if (!password_verify($data["password"], $user["password"])) {
            $_SESSION["error"] = "The password doesnt match.";
            return;
        }

        $_SESSION["id"] = $user["id"];
        header("Location: index.php");
        exit;
    }

    public function signUp(array $data): void
    {
        if (empty($data) || empty($data["email"]) || empty($data["password"]) || empty($data["username"]) || empty($data["passwordConfirmation"])) {
            $_SESSION["error"] = "All fields are required.";
            return;
        }

        if (!empty($this->userModel->findByEmail($data["email"]))) {
            $_SESSION["error"] = "That email already exists.";
            return;
        }

        if (strlen($data["password"]) < 6) {
            $_SESSION["error"] = "The password is too short.";
            return;
        }

        if ($data["password"] !== $data["passwordConfirmation"]) {
            $_SESSION["error"] = "The passwords doesnt match.";
            return;
        }

        unset($data["passwordConfirmation"]);
        $passwordHash = password_hash($data["password"], PASSWORD_DEFAULT);

        $data["password"] = $passwordHash;
        $data["email"] = filter_var(trim($data["email"]), FILTER_SANITIZE_EMAIL);
        $data["username"] = htmlspecialchars($data["username"]);

        $_SESSION["id"] = $this->userModel->insertUser($data);
        header("Location: index.php");
        exit;
    }

    public function logOut(): void
    {
        session_destroy();
        header("Location: /Instagram_Clone/signUp.php");
        exit;
    }
}
