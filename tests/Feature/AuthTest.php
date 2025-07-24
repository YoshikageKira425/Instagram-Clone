<?php

require __DIR__ . "/../../src/controllers/AuthController.php";

session_start();

test('login fails when no data is sent', function () {
    (new AuthController)->logIn([]);

    expect($_SESSION["error"])->toBeString()->toBe("All fields are required.");
});

test('login fails when the email doesnt exits in the database', function () {
    (new AuthController)->logIn(["email" => "eneshalili@gmail.com", "password" => "1234567"]);

    expect($_SESSION["error"])->toBeString()->toBe("That email doesnt exits.");
});

test('login fails when the password is wrong', function () {
    (new AuthController)->logIn(["email" => "eneshalili425@gmail.com", "password" => "123141"]);

    expect($_SESSION["error"])->toBeString()->toBe("The password doesnt match.");
});

test('login was a success', function () {
    (new AuthController)->logIn(["email" => "eneshalili425@gmail.com", "password" => "1234567"]);

    expect($_SESSION["error"])->toBeString()->toBe("");
});

test('signup fails when no data is sent', function () {
    (new AuthController)->signUp([]);
    
    expect($_SESSION["error"])->toBeString()->toBe("All fields are required.");
});

test('signup fails when the email exits', function () {
    (new AuthController)->signUp(["email" => "eneshalili425@gmail.com", "password" => "1234567", "username" => "enes", "passwordConfirmation" => "1234"]);
    
    expect($_SESSION["error"])->toBeString()->toBe("That email already exists.");
});

test('signup fails when the password is too short', function () {
    (new AuthController)->signUp(["email" => "eneshalili@gmail.com", "password" => "123", "username" => "enes", "passwordConfirmation" => "1234"]);
    
    expect($_SESSION["error"])->toBeString()->toBe("The password is too short.");
});

test('signup fails when the password and passwordConfirmation dont match', function () {
    (new AuthController)->signUp(["email" => "eneshalili@gmail.com", "password" => "1234567", "username" => "enes", "passwordConfirmation" => "123123123"]);
    
    expect($_SESSION["error"])->toBeString()->toBe("The passwords doesnt match.");
});

test('signup is a success', function () {
    (new AuthController)->signUp(["email" => "eneshalili@gmail.com", "password" => "1234567", "username" => "enes", "passwordConfirmation" => "123123123"]);
    
    expect($_SESSION["error"])->toBeString()->toBe("");
    expect($_SESSION["id"])->toBeInt()->toBeNumeric()->toBeDigits();
});