<?php
session_start();

if (!isset($_SESSION["studentId"])) {
    // $studentId = $_SESSION["studentId"];
    // User is logged in, redirect to the home page
    header("Location: ./login/");
    exit;
} else {
    $studentId = $_SESSION["studentId"];
}

// LOGOUT
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to login page after logout
    header("Location: ./login/");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SUB</title>
    <link rel="stylesheet" href="./style/index.css">
</head>

<body>
    <div id="sidebar">
        <div class="logo"><img src="./images/logo.png" alt=""></div>
        <div class="menu-item active" data-page="home">Home</div>
        <div class="menu-item" data-page="p2">Page 2</div>
        <div class="menu-item" data-page="p3">Page 3</div>
        <!-- <div class="menu-item" data-page="p4">Page 4</div> -->

        <!-- More menu items... -->
    </div>

    <nav>
        <a href="?logout=true" class="logout-button">Logout</a>
    </nav>
    <header>
        <h1>Lorem ipsum dolor sit amet header.</h1>
    </header>

    <main>
        <!-- Page content will be loaded here -->
    </main>


    <script src="./script/index.js"></script>

</body>

</html>