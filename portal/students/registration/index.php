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
    <title>Student Registration</title>
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
                    <label class="required" for="studentId">Student ID</label>
                    <input type="text" id="studentId" name="studentId" required placeholder="CSE12345678">
                </div>

                <div>
                    <label class="required" for="batch">Batch</label>
                    <input type="text" id="batch" name="batch" required placeholder="78X">
                </div>

                <div>
                    <label class="required" for="department">Department</label>
                    <input type="text" id="department" name="department" required placeholder="CSE">
                </div>

                <div>
                    <label class="required" for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="you@gmail.com">
                </div>

                <div>
                    <label class="required" for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="password">
                </div>

                <div>
                    <label class="required" for="securityQuestion">Security Question</label>
                    <select id="securityQuestion" name="securityQuestion" required>
                        <!-- <option value="">Select a security question</option> -->
                        <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                        <option value="What is the name of your first pet?">What is the name of your first pet?</option>
                        <option value="In which city were you born?">In which city were you born?</option>
                    </select>
                </div>

                <div>
                    <label class="required" for="securityAnswer">Security Answer</label>
                    <input type="text" id="securityAnswer" name="securityAnswer" required>
                </div>

                <input class="submit" type="submit" value="Register">
                <br>
                <span>
                    <p>Already have an account?</p><a href="../login/">Login</a>
                </span>
            </form>
        </div>
        <img src="https://images.pexels.com/photos/1438081/pexels-photo-1438081.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="" loading="lazy">
    </section>

</body>

</html>