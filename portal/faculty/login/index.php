<?php
session_start();

if (isset($_SESSION["studentId"])) {
    $studentId = $_SESSION["studentId"];
    // User is logged in, redirect to the home page
    header("Location: ../$studentId");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Student Login</title>
</head>

<body>
    <?php //include '../nav.php'; 
    ?>

    <section>
        <div class="form">

            <div class="title">
                <img src="../images/logo.png" alt="">
                <h2>Login to Stamford</h2>
            </div>

            <form action="login.php" method="post">
                <div>
                    <label class="required" for="studentId">Student ID</label>
                    <input type="text" id="studentId" name="studentId" placeholder="CSE12345678" required>
                </div>

                <div>
                    <label class="required" for="batch">Batch</label>
                    <input type="text" id="batch" name="batch" placeholder="78X" required>
                </div>

                <div>
                    <label class="required" for="department">Department</label>
                    <input type="text" id="department" name="department" placeholder="CSE" required>
                </div>

                <div>
                    <label class="required" for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <input class="submit" type="submit" value="Login">
                <span>
                    <a href="../registration/">Create account</a><a href="#">Forgot Password?</a>
                </span>
            </form>
        </div>
        <img src="https://images.pexels.com/photos/1438081/pexels-photo-1438081.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" loading="lazy">
    </section>
    <?php //include '../footer.php'; 
    ?>
</body>

</html>