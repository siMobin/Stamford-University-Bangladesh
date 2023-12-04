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

    $motherName = htmlspecialchars($_POST["MotherName"]);
    $fatherName = htmlspecialchars($_POST["FatherName"]);
    $fatherOccupation = htmlspecialchars($_POST["FatherOccupation"]);
    $parentName = htmlspecialchars($_POST["ParentName"]);
    $parentConnection = htmlspecialchars($_POST["ParentConnection"]);

    $permanentAddress = htmlspecialchars($_POST["PermanentAddress"]);
    $presentAddress = htmlspecialchars($_POST["PresentAddress"]);

// Insert data into the students table
$insertStudentsQuery = "INSERT INTO students (UID, StudentId, FirstName, LastName, DateOfBirth, RegNo, Email, Batch, Department, Program, Country, Semester, AdmissionDate, MotherName, FatherName, FatherOccupation, ParentName, ParentConnection, PermanentAddress, PresentAddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$params = array(
    $uid, $studentId, $firstName, $lastName, $dateOfBirth, $regNo, $email, $batch, $department, $program,
    $country, $semester, $admissionDate, $motherName, $fatherName, $fatherOccupation, $parentName, $parentConnection,
    $permanentAddress, $presentAddress
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

    // You may also insert data into the student_login table here if needed

    // Redirect to a success page or perform other actions
    header("Location: ../");
    exit();
}

// Function to generate a random 16-digit UID
function generateUID() {
    $characters = '0123456789';
    $uid = '';
    for ($i = 0; $i < 16; $i++) {
        $uid .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $uid;
}

// Function to determine the current semester
function getSemester() {
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Form</title>


<script>
    // JavaScript to add and remove phone number input fields
    function addPhoneNumber() {
        var container = document.getElementById("phoneContainer");

        // Create and append phone number input and connection type dropdown
        var phoneGroup = createPhoneGroup();
        container.appendChild(phoneGroup);
    }

    function removePhoneNumber() {
        var container = document.getElementById("phoneContainer");
        var phoneGroups = container.getElementsByClassName("phone-group");

        // Ensure there is at least one phone number input
        if (phoneGroups.length >= 1) {
            container.removeChild(phoneGroups[phoneGroups.length - 1]);
        }
    }

    function createPhoneGroup() {
        var phoneGroup = document.createElement("div");
        phoneGroup.className = "phone-group";

        // Create and append phone number input
        var input = createPhoneNumberInput();
        phoneGroup.appendChild(input);

        // Create and append connection type dropdown directly in HTML
        phoneGroup.innerHTML += `
            <label for="connectionTypes[]">Connection Type:</label>
            <select name="connectionTypes[]" required>
                <option value="self">Self</option>
                <option value="parent">Parent</option>
                <option value="guardian">Guardian</option>
            </select>
        `;

        return phoneGroup;
    }

    function createPhoneNumberInput() {
        var input = document.createElement("input");
        input.type = "text";
        input.name = "phones[]";
        input.placeholder = "Phone Number";
        return input;
    }

</script>

</head>
<body>
    <h1>Student Information Form</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="StudentId">Student ID:</label>
        <input type="text" name="StudentId" required>

        <label for="FirstName">First Name:</label>
        <input type="text" name="FirstName" required>

        <label for="LastName">Last Name:</label>
        <input type="text" name="LastName" required>

        <label for="DateOfBirth">Date of Birth:</label>
        <input type="date" name="DateOfBirth" required>

        <label for="RegNo">Registration Number:</label>
        <input type="text" name="RegNo">

        <label for="Email">Email:</label>
        <input type="email" name="Email" required>

        <label for="Batch">Batch:</label>
        <input type="text" name="Batch" required>

        <label for="Department">Department:</label>
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

        <label for="Program">Program:</label>
        <select name="Program" required>
            <option value="Undergraduate">Undergraduate</option>
            <option value="Graduate">Graduate</option>
        </select>

        <label for="Country">Country:</label>
        <input type="text" name="Country" required>

        <label for="Semester">Semester:</label>
        <input type="text" name="Semester" value="<?php echo getSemester(); ?>" readonly>

        <label for="AdmissionDate">Admission Date:</label>
        <input type="date" name="AdmissionDate" value="<?php echo date('Y-m-d'); ?>" required>

        <label for="MotherName">Mother's Name:</label>
        <input type="text" name="MotherName" required>

        <label for="FatherName">Father's Name:</label>
        <input type="text" name="FatherName" required>

        <label for="FatherOccupation">Father's Occupation:</label>
        <input type="text" name="FatherOccupation" required>

        <label for="ParentName">Parent's Name:</label>
        <input type="text" name="ParentName">

        <label for="ParentConnection">Parent's Connection:</label>
        <input type="text" name="ParentConnection">

        <label for="PermanentAddress">Permanent Address:</label>
        <textarea name="PermanentAddress" rows="4" required></textarea>

        <label for="PresentAddress">Present Address:</label>
        <textarea name="PresentAddress" rows="4" required></textarea>

        <label for="phones">Phone Numbers:</label>
        <div id="phoneContainer">
            <input type="text" name="phones[]" placeholder="Phone Number" required >
            <label for="connectionTypes[]">Connection Type:</label>
            <select name="connectionTypes[]" required>
                <option value="self">Self</option>
                <option value="parent">Parent</option>
                <option value="guardian">Guardian</option>
            </select>
        </div>

        <button type="button" onclick="addPhoneNumber()">Add More Phones</button>
        <button type="button" onclick="removePhoneNumber()">Remove Last Phone</button>

        <button type="submit">Submit</button>
    </form>
</body>
</html>

