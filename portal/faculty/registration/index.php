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
    <title>Faculty Registration</title>
</head>

<body>
    <section>
        <div class="form">

            <div class="title">
                <img src="../images/logo.png" alt="">
                <h2>Create a new account</h2>
            </div>

            <form action="register.php" method="post">

                <div>
                    <label class="required" for="FacultyId">Faculty ID</label>
                    <input type="text" id="FacultyId" name="FacultyId" required placeholder="CSE12345678">
                </div>

                

                <div>
                    <label class="required" for="Department">Department</label>
                    <input type="text" id="Department" name="Department" required placeholder="CSE">
                </div>

                <div>
                    <label class="required" for="Email">Email</label>
                    <input type="email" id="Email" name="Email" required placeholder="you@gmail.com">
                </div>

                <div>
                    <label class="required" for="Password">Password</label>
                    <input type="password" id="Password" name="Password" required placeholder="password">
                </div>

                <div>
                    <label class="required" for="SecurityQuestion">Security Question</label>
                    <select id="SecurityQuestion" name="SecurityQuestion" required>
                        <!-- <option value="">Select a security question</option> -->
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                        <option value="In which city were you born?">In which city were you born?</option>
                    </select>
                </div>

                <div>
                    <label class="required" for="SecurityAnswer">Security Answer</label>
                    <input type="text" id="SecurityAnswer" name="SecurityAnswer" required>
                </div>

                <input class="submit" type="submit" value="Register">
                <br>
                <span>
                    <p>Already have an account?</p><a href="../login/">Login</a>
                </span>
            </form>
        </div>
        <img src="https://www.interfolio.com/wp-content/uploads/Blog-facultyservice.jpg" alt="" loading="lazy">
    </section>

</body>

</html>