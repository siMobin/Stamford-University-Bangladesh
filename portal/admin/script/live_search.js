/**
 * Retrieves data from the server and updates the table content based on the search input.
 *
 * @param {string} str - The search input string.
 * @return {undefined} This function does not return a value.
 */
function showResult(str) {
    // Clear table content if search input is empty //

    if (str.length == 0) {
        document.getElementById("tableContent").innerHTML = "";
        return;
    }
    var xmlhttp = new XMLHttpRequest();

    /**
     * Sets the innerHTML of the element with id "tableContent" to the responseText of the XMLHttpRequest object.
     *
     * @param {None} None - This function does not take any parameters.
     * @return {None} This function does not return a value.
     */
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableContent").innerHTML = this.responseText; // Replace table content with search results
        }
    }
    xmlhttp.open("GET", "./students/livesearch.php?data=" + str, true);
    xmlhttp.send();
}