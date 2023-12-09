
// Load JSON data from the file
var jsonFile = '../../../storage/json_files/course_info.json';
var jsonData = {};

fetch(jsonFile)
    .then(response => response.json())
    .then(data => jsonData = data)
    .then(() => updateFlagOptions());

// Function to update the flag options based on the selected department
function updateFlagOptions() {
    var departmentSelect = document.getElementsByName("department")[0];
    var flagSelect = document.getElementById("flagSelect");

    // Clear existing options
    flagSelect.innerHTML = '';

    // Get selected department
    var selectedDepartment = departmentSelect.value;

    // Check if the department exists in the JSON data
    if (jsonData[selectedDepartment]) {
        // Iterate through the flags for the selected department and add them as options
        Object.keys(jsonData[selectedDepartment]).forEach(function (flag) {
            var option = document.createElement("option");
            option.value = flag;
            option.text = flag;
            flagSelect.add(option);
        });
    }
}

// Add an event listener to the department select to update flag options on change
document.getElementsByName("department")[0].addEventListener("change", updateFlagOptions);


//////////////////////////////////////////////////////
//////////////////////////////////////////////////////

function toggleCourseButtons() {
    var overrideCheckbox = document.getElementById("override_flag");
    var addCourseBtn = document.getElementById("addCourseBtn");
    var removeCourseBtn = document.getElementById("removeCourseBtn");

    if (overrideCheckbox.checked) {
        addCourseBtn.style.display = "inline-block";
        removeCourseBtn.style.display = "inline-block";
    } else {
        addCourseBtn.style.display = "none";
        removeCourseBtn.style.display = "none";
    }
}

function addCourse() {
    var courseListDiv = document.getElementById("courseList");
    var overrideCheckbox = document.getElementsByName("override_flag")[0];

    if (overrideCheckbox.checked) {
        // Create a new text input for course code
        var courseInput = document.createElement("input");
        courseInput.type = "text";
        courseInput.name = "courses[]"; // Use an array to handle multiple courses
        courseInput.placeholder = "Enter Course Code";
        courseInput.required = true;

        // Append the new text input to the courseListDiv
        courseListDiv.appendChild(courseInput);
    } else {
        alert("Please check the 'Override Flag' checkbox to manually add courses.");
    }
}

function removeCourse() {
    var courseListDiv = document.getElementById("courseList");
    var courseInputs = courseListDiv.getElementsByTagName("input");

    // Check if there's at least one course to remove
    if (courseInputs.length > 0) {
        // Remove the last text input element
        courseListDiv.removeChild(courseInputs[courseInputs.length - 1]);
    }
}

