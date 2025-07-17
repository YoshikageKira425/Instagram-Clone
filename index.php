<?php

session_start();

if (empty($_SESSION) || empty($_SESSION["id"]))
{
    header("Location: signUp.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram</title>
    <link rel="shortcut icon" href="/Instagram_Clone/assets/images/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="/Instagram_Clone/assets/style/output.css   ">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <h1>HELLO</h1>
</body>
</html>