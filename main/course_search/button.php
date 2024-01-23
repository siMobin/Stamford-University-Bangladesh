     <!-- Add download button -->
     <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="generatePDF" value="true">
        <input type="hidden" name="department" value="<?php echo isset($_POST["department"]) ? $_POST["department"] : ''; ?>">
        <button class="submit" type="submit">Download as PDF</button>
    </form>
    <script>
        document.getElementById('department').addEventListener('change', function() {
            var department = this.value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("courseList").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("POST", "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("department=" + department);
        });
    </script>
