document.addEventListener('DOMContentLoaded', function () {
    var menuItems = document.querySelectorAll('.menu-item');

    /**
     * Sets the active page and sets the `hx-get` attribute for menu items.
     *
     * @param {type} paramName - description of parameter
     * @return {type} description of return value
     */
    function setActiveAndHxGet() {
        const lastActivePage = localStorage.getItem('activePage');
        menuItems.forEach(menuItem => {
            menuItem.classList.remove('active');
            const dataPage = menuItem.getAttribute('data-page');
            menuItem.setAttribute('hx-get', dataPage);
            if (dataPage === lastActivePage) {
                menuItem.classList.add('active');
                menuItem.setAttribute('hx-get', lastActivePage);
            }
        });
    }

    // Simulate a click on the last active menu item after page load
    window.addEventListener('load', function () {
        setActiveAndHxGet();
        var lastActivePage = localStorage.getItem('activePage');
        var lastActiveMenuItem = document.querySelector('.menu-item[data-page="' + (lastActivePage || 'home') + '"]');
        if (lastActiveMenuItem) {
            lastActiveMenuItem.click();
        }
    });

    /**
     * Handle click event.
     *
     * @param {Event} event - The click event.
     * @return {undefined} This function does not return a value.
     */
    function handleClick(event) {
        const { target } = event;
        const currentPage = target.getAttribute('data-page');
        localStorage.activePage = currentPage;
        setActiveAndHxGet();
    }

    // Attach click event listeners
    menuItems.forEach(function (item) {
        item.addEventListener('click', handleClick);
    });
});


// Get the button and sidebar elements
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebar = document.getElementById('sidebar');

// Add click event listener to the toggle button
sidebarToggle.addEventListener('click', function () {
    // Toggle the 'hidden' class on the sidebar
    sidebar.classList.toggle('hidden');
});

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

