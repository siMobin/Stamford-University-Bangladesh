/**
 * Opens a tab and hides all other tabs.
 *
 * @param {Event} evt - The event object that triggered the function.
 * @param {string} x - The ID of the tab to open.
 * @return {void} This function does not return anything.
 */
function open_tab(evt, x) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(x).style.display = "flex";
    evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();