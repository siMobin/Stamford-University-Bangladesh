/**
 * Loads a page using an XMLHttpRequest.
 *
 * @param {string} page - The URL of the page to load.
 * @return {void} This function does not return a value.
 */
function loadPage(page) {
    // Create a new XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Setup the GET request
    xhr.open('GET', page + '/', true);

    // Setup the onload function
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Update the main content area with the loaded data
            document.querySelector('main').innerHTML = xhr.responseText;
        }
    };

    // Send the request
    xhr.send();
}


// Get all menu items
var menuItems = document.querySelectorAll('.menu-item');

// Add click event listener for each menu item
menuItems.forEach(function (menuItem) {
    menuItem.addEventListener('click', function () {
        // Remove the 'active' class from all menu items
        menuItems.forEach(function (item) {
            item.classList.remove('active');
        });

        // Add the 'active' class to the clicked menu item
        this.classList.add('active');

        // Get the data-page attribute of the clicked menu item
        var page = this.getAttribute('data-page');

        // Save the active menu item in localStorage
        localStorage.setItem('activePage', page);

        // Load the page content
        loadPage(page);
    });
});

// Retrieve the last active menu item from localStorage
var lastActivePage = localStorage.getItem('activePage');

// Simulate a click on the last active menu item or the default active menu item
document.querySelector('.menu-item[data-page="' + (lastActivePage || 'home') + '"]').click();

/**
 * Retrieves search results based on the selected semester.
 *
 * @param {string} selectedSemester - The selected semester.
 * @return {void} The function does not return a value.
 */
function searchResults() {
    var selectedSemester = $("#semester").val();

    $.ajax({
        type: "POST",
        url: "./result_search/index.php", // Update the URL to match the correct path
        data: { semester: selectedSemester },
        success: function (response) {
            // Display the results in the resultContainer
            $("#resultContainer").html(response);
        }
    });
}

$(document).ready(function () {
    // Attach the event handler to the searchButton
    $("#searchButton").click(searchResults);

    // Call the function when the page loads
    searchResults();
});

