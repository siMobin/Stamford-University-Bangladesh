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
