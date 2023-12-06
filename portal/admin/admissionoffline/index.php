<?php
require_once('../../../conn.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize form inputs
    $uid = generateUID();
    $studentId = htmlspecialchars($_POST["StudentId"]);
    $firstName = htmlspecialchars($_POST["FirstName"]);
    $lastName = htmlspecialchars($_POST["LastName"]);
    $dateOfBirth = htmlspecialchars($_POST["DateOfBirth"]);
    $regNo = htmlspecialchars($_POST["RegNo"]);
    $email = htmlspecialchars($_POST["Email"]);
    $batch = htmlspecialchars($_POST["Batch"]);
    $department = htmlspecialchars($_POST["Department"]);
    $program = htmlspecialchars($_POST["Program"]);
    $country = htmlspecialchars($_POST["Country"]);
    $semester = getSemester();
    $admissionDate = (empty($_POST["AdmissionDate"])) ? date("Y-m-d") : $_POST["AdmissionDate"];
    $gender = htmlspecialchars($_POST["Gender"]);

    $motherName = htmlspecialchars($_POST["MotherName"]);
    $fatherName = htmlspecialchars($_POST["FatherName"]);
    $fatherOccupation = htmlspecialchars($_POST["FatherOccupation"]);
    $parentName = htmlspecialchars($_POST["ParentName"]);
    $parentConnection = htmlspecialchars($_POST["ParentConnection"]);

    $permanentAddress = htmlspecialchars($_POST["PermanentAddress"]);
    $presentAddress = htmlspecialchars($_POST["PresentAddress"]);

    // Insert data into the students table
    $insertStudentsQuery = "INSERT INTO students (UID, StudentId, FirstName, LastName, DateOfBirth, RegNo, Email, Batch, Department, Program, Country, Semester, AdmissionDate, MotherName, FatherName, FatherOccupation, ParentName, ParentConnection, PermanentAddress, PresentAddress, Gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $params = array(
        $uid, $studentId, $firstName, $lastName, $dateOfBirth, $regNo, $email, $batch, $department, $program,
        $country, $semester, $admissionDate, $motherName, $fatherName, $fatherOccupation, $parentName, $parentConnection,
        $permanentAddress, $presentAddress, $gender
    );

    $stmt = sqlsrv_query($conn, $insertStudentsQuery, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Insert data into the phone table
    $phones = $_POST["phones"];
    $connectionTypes = $_POST["connectionTypes"];

    foreach ($phones as $index => $phone) {
        // Get the corresponding connection type from the form
        $connectionType = $connectionTypes[$index];

        $insertPhoneQuery = "INSERT INTO phone (StudentId, Phone, ConnectionType) VALUES (?, ?, ?)";
        $paramsPhone = array($studentId, $phone, $connectionType);
        $stmtPhone = sqlsrv_query($conn, $insertPhoneQuery, $paramsPhone);

        if ($stmtPhone === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    // Redirect to a success page or perform other actions
    header("Location: ../");
    exit();
}

// Function to generate a random 16-digit UID
function generateUID()
{
    $characters = '0123456789';
    $uid = '';
    for ($i = 0; $i < 16; $i++) {
        $uid .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $uid;
}

// Function to determine the current semester
function getSemester()
{
    $currentMonth = date("n");
    $currentYear = date("Y");

    if ($currentMonth >= 5 && $currentMonth <= 8) {
        return "Summer $currentYear";
    } elseif ($currentMonth > 11) {
        return "Spring " . ($currentYear + 1);
    } elseif ($currentMonth < 3) {
        return "Spring $currentYear";
    } else {
        // Add more cases as needed
        return "Unknown Semester";
    }
}
?>

<h1 class="form_title">Offline Admission Form</h1>

<section class="form_container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="StudentId">Student ID</label>
                <input type="text" name="StudentId" required placeholder="Enter Student ID">
            </div>
            <div class="box-small">
                <!-- empty div -->
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="AdmissionDate">Admission Date</label>
                <input type="date" name="AdmissionDate" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="box-small">
                <!-- empty div -->
            </div>
        </div>

        <br>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="FirstName">First Name</label>
                <input type="text" name="FirstName" required placeholder="Enter First Name">
            </div>

            <div class="box-small">
                <label class="required" for="LastName">Last Name</label>
                <input type="text" name="LastName" required placeholder="Enter Last Name">
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="MotherName">Mother's Name</label>
                <input type="text" name="MotherName" required placeholder="Enter Mother's Name">
            </div>

            <div class="box-small">
                <label class="required" for="FatherName">Father's Name</label>
                <input type="text" name="FatherName" required placeholder="Enter Father's Name">
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="FatherOccupation">Father's Occupation</label>
                <input type="text" name="FatherOccupation" required placeholder="Father's Occupation">
            </div>
            <div class="box-small">
                <!-- empty div -->
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="Gender">Gender</label>
                <select name="Gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>

            <div class="box-small">
                <label class="required" for="DateOfBirth">Date of Birth</label>
                <input type="date" name="DateOfBirth" required placeholder="Enter Date of Birth">
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="Department">Department</label>
                <select name="Department" required>
                    <option value="BBA">BBA</option>
                    <option value="BPH">BPH</option>
                    <option value="EEE">EEE</option>
                    <option value="MBO">MBO</option>
                    <option value="LLB">LLB</option>
                    <option value="CEN">CEN</option>
                    <option value="ENG">ENG</option>
                    <option value="FLM">FLM</option>
                    <option value="CSE">CSE</option>
                    <option value="ECO">ECO</option>
                    <option value="ENV">ENV</option>
                    <option value="JRN">JRN</option>
                    <option value="ARC">ARC</option>
                    <option value="BPA">BPA</option>
                    <option value="MBA">MBA</option>
                    <option value="MCA">MCA</option>
                    <option value="MFF">MFF</option>
                    <option value="MFM">MFM</option>
                    <option value="ENP">ENP</option>
                    <option value="ENF">ENF</option>
                    <option value="MMB">MMB</option>
                    <option value="MES">MES</option>
                    <option value="MPA">MPA</option>
                    <option value="LMF">LMF</option>
                    <option value="LMP">LMP</option>
                    <option value="MPM">MPM</option>
                    <option value="MJP">MJP</option>
                    <option value="MJR">MJR</option>
                    <option value="MEC">MEC</option>
                    <option value="JLC">JLC</option>
                    <option value="CNA">CNA</option>
                </select>
            </div>

            <div class="box-small">
                <label class="required" for="Program">Program</label>
                <select name="Program" required>
                    <option value="Undergraduate">Undergraduate</option>
                    <option value="Graduate">Graduate</option>
                </select>
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="Batch">Batch</label>
                <input type="text" name="Batch" required placeholder="Enter Batch">
            </div>

            <div class="box-small">
                <label for="Semester">Semester</label>
                <input type="text" name="Semester" value="<?php echo getSemester(); ?>" readonly>
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label for="RegNo">Registration Number</label>
                <input type="text" name="RegNo" placeholder="Registration Number SSC/HSC">
            </div>

            <div class="box-small">
                <label class="required" for="Country">Country</label>
                <input type="text" name="Country" value="Bangladesh" required placeholder="Country">
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label for="ParentName">Guardian's Name</label>
                <input type="text" name="ParentName" placeholder="Guardian's Name">
            </div>

            <div class="box-small">
                <label for="ParentConnection">Guardian's Connection</label>
                <input type="text" name="ParentConnection" placeholder="Guardian's Connection">
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="PermanentAddress">Permanent Address</label>
                <textarea name="PermanentAddress" rows="2" required placeholder="Permanent Address"></textarea>
            </div>

            <div class="box-small">
                <label class="required" for="PresentAddress">Present Address</label>
                <textarea name="PresentAddress" rows="2" required placeholder="Present Address"></textarea>
            </div>
        </div>

        <div class="box-big">
            <div class="box-small">
                <label class="required" for="phones">Phone Numbers</label>
                <div id="phoneContainer">
                    <input type="text" name="phones[]" placeholder="Phone Number" required>

                    <label class="required" for="connectionTypes[]">Connection Type:</label>
                    <select name="connectionTypes[]" required>
                        <option value="self">Self</option>
                        <option value="parent">Parent</option>
                        <option value="guardian">Guardian</option>
                    </select>
                </div>
            </div>

            <div class="box-small">
                <label class="required" for="Email">Email:</label>
                <input type="email" name="Email" required placeholder="Email">
            </div>
        </div>

        <div class="box-small">
            <button class="submit" type="button" onclick="addPhoneNumber()">Add More Phones</button>
            <button class="submit" type="button" onclick="removePhoneNumber()">Remove Last Phone</button>
        </div>

        <button class="submit" type="submit">Submit</button>
    </form>
</section>