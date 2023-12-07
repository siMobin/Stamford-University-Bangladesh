<?php
session_start();

if (isset($_SESSION["FacultyId"])) {
    $studentId = $_SESSION["FacultyId"];
    // User is logged in, redirect to the home page
    header("Location: ../$FacultyId");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Faculty Login</title>
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
                    <label class="required" for="FacultyId">Faculty ID</label>
                    <input type="text" id="FacultyId" name="FacultyId" placeholder="CSE1234567" required>
                </div>

                <div>
                    <label class="required" for="Department">Department</label>
                    <input type="text" id="Department" name="Department" placeholder="CSE" required>
                </div>

                <div>
                    <label class="required" for="Email">Email</label>
                    <input type="text" id="Email" name="Email" placeholder="you@stamford.com" required>
                </div>

                <div>
                    <label class="required" for="Password">Password</label>
                    <input type="Password" id="Password" name="Password" required>
                </div>

                <input class="submit" type="submit" value="Login">
                <span>
                    <a href="../registration/">Create account</a><a href="#">Forgot Password?</a>
                </span>
            </form>
        </div>
        <img src="https://www.interfolio.com/wp-content/uploads/Blog-facultyservice.jpg" alt="" loading="lazy">
    </section>
    <?php //include '../footer.php'; 
    ?>
</body>

</html>