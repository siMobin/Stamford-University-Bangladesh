/**
 * Reads the contents of a file and displays a preview of it.
 *
 * @param {object} input - The input element that represents the file input.
 * @return {void} This function does not return a value.
 */
function readFile(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var file = input.files[0];

        /**
         * Sets the preview image source based on the file type.
         *
         * @param {Event} e - The event object containing the file data.
         * @return {void} This function does not return anything.
         */
        reader.onload = function (e) {
            var preview = $('#preview');
            if (file.type.match('image.*')) {
                preview.attr('src', e.target.result);
            } else if (file.type.match('video.*')) {
                // Set a default thumbnail for videos
                preview.attr('src', './images/thumbnail.svg');
            } else if (file.type === 'application/pdf') {
                // For PDFs - create a placeholder PDF thumbnail
                preview.attr('src', './images/pdf-thumbnail.svg');
            }
        };

        reader.readAsDataURL(file);
    }

    var fileUploadSpan = document.getElementById('fileUpload');
    if (input.files && input.files[0]) {
        // Hide or set opacity to 0 for the span element
        // fileUploadSpan.style.display = 'none'; // Hide the span element
        // OR
        fileUploadSpan.style.opacity = '0'; // Set opacity to 0 for the span element
        // OR
        // fileUploadSpan.classList.add('hidden'); // Apply a CSS class with display: none or opacity: 0
    }
}