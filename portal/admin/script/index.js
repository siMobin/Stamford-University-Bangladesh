/**
 * Toggles the submenu display based on the event target.
 *
 * @param {Event} event - The event object triggered by the user.
 * @return {void} This function does not return a value.
 */
function toggleSubmenu(event) {
    var submenu = document.getElementById('submenu');
    var target = event.target;

    // Check if the clicked element has the class "menu-item" and text content is "Page 3"
    if (target.classList.contains('menu-drop')) {
        submenu.style.display = (submenu.style.display === 'none' || submenu.style.display === '') ? 'block' : 'none';
    }
}

/**
 * Load a page using XMLHttpRequest and update the main content area with the loaded data.
 *
 * @param {string} page - The URL of the page to load.
 * @return {void} This function does not return a value.
 */
function loadPage(page) {
    // Create a new XMLHttpRequest
    var xhr = new XMLHttpRequest();

    // Setup the GET request
    xhr.open('GET', page + '/', true);

    /**
     * Sets the `onload` event handler for the `xhr` object.
     * If the status of the `xhr` object is 200, it updates the main content area
     * with the loaded data from the `responseText` property.
     *
     * @param {Event} event - The event object.
     * @return {undefined} This function does not return a value.
     */
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
