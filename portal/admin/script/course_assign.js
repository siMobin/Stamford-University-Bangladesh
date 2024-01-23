// Load JSON data from the file
var jsonFile = '../../../storage/json_files/course_info.json';
var jsonData = {};

// Function to update the flag options based on the selected department
function updateFlagOptions() {
    var departmentSelect = document.getElementsByName("department")[0];
    var flagSelect = document.getElementById("flagSelect");

    // Check if departmentSelect and flagSelect are available
    if (departmentSelect && flagSelect) {
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
}

// Function to add event listener to the department select
function addDepartmentChangeListener() {
    var departmentSelect = document.getElementsByName("department")[0];

    // Check if departmentSelect is available
    if (departmentSelect) {
        departmentSelect.addEventListener("change", updateFlagOptions);
    }
}

// Add an event listener to the window load event
window.addEventListener('load', function () {
    // Fetch JSON data
    fetch(jsonFile)
        .then(response => response.json())
        .then(data => {
            jsonData = data;
            updateFlagOptions(); // Call the function here after data is loaded
            addDepartmentChangeListener(); // Add the event listener here
        })
        .catch(error => {
            console.error('Error fetching JSON data:', error);
        });
});

// Rest of your code remains unchanged