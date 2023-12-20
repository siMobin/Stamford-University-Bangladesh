/**
 * Adds a phone number input and connection type dropdown to the phone container.
 *
 * @param {type} container - the element that contains the phone number inputs and dropdowns
 * @return {type} undefined
 */
function addPhoneNumber() {
    var container = document.getElementById("phoneContainer");

    // Create and append phone number input and connection type dropdown
    var phoneGroup = createPhoneGroup();
    container.appendChild(phoneGroup);
}

/**
 * Removes the last phone number input from the phone container.
 *
 * @param {none} none - no parameters
 * @return {none} none - does not return anything
 */
function removePhoneNumber() {
    var container = document.getElementById("phoneContainer");
    var phoneGroups = container.getElementsByClassName("phone-group");

    // Ensure there is at least one phone number input
    if (phoneGroups.length >= 1) {
        container.removeChild(phoneGroups[phoneGroups.length - 1]);
    }
}

/**
 * Creates a phone group element.
 *
 * @return {HTMLElement} The created phone group element.
 */
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

/**
 * Creates a phone number input element.
 *
 * @return {HTMLInputElement} The created input element for phone numbers.
 */
function createPhoneNumberInput() {
    var input = document.createElement("input");
    input.type = "text";
    input.name = "phones[]";
    input.placeholder = "Phone Number";
    return input;
}
