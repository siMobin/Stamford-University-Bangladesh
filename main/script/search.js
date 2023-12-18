// Get all anchor tags within the navigation section
const navLinks = document.querySelectorAll('nav a');

// Extract text content and href attributes and store in an array of objects
const linkInfo = Array.from(navLinks).map(link => ({
    text: link.textContent.trim(),
    href: link.getAttribute('href')
}));

/**
 * Returns an array of suggestions based on the given input.
 *
 * @param {string} input - The input used to generate suggestions.
 * @return {array} An array of suggestions that match the input.
 */
function getSuggestions(input) {
    return input ? linkInfo.filter(link => link.text.toLowerCase().includes(input.toLowerCase())) : [];
}

/**
 * Displays a list of suggestions on the webpage.
 *
 * @param {Array} suggestions - An array of suggestion objects.
 * @return {undefined} This function does not return a value.
 */
function showSuggestions(suggestions) {
    const suggestionsContainer = document.getElementById('suggestions');

    if (suggestions.length) {
        suggestionsContainer.innerHTML = ''; // Clear previous suggestions

        const suggestionsList = document.createElement('ul');

        suggestions.forEach(link => {
            const listItem = document.createElement('li');
            const suggestionLink = document.createElement('a');
            suggestionLink.href = link.href; // Set the original href
            suggestionLink.textContent = link.text;
            listItem.appendChild(suggestionLink);
            suggestionsList.appendChild(listItem);
        });

        suggestionsContainer.appendChild(suggestionsList);
        suggestionsContainer.style.display = 'block';
    } else {
        suggestionsContainer.style.display = 'none';
    }
}

// Event listener for input change
document.getElementById('searchInput').addEventListener('input', function () {
    const inputValue = this.value.trim(); // Remove leading/trailing spaces
    const suggestions = getSuggestions(inputValue);
    showSuggestions(suggestions);
});

// Close suggestions when clicking outside the search box
document.addEventListener('click', function (event) {
    const suggestionsContainer = document.getElementById('suggestions');
    const searchInput = document.getElementById('searchInput');

    if (event.target !== suggestionsContainer && event.target !== searchInput) {
        suggestionsContainer.style.display = 'none';
    }
});