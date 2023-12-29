const uploadField = document.getElementById("file");

/**
 * Handles the onchange event of the uploadField element.
 *
 * @param {Event} event - The onchange event object.
 * @return {undefined} This function does not return a value.
 */
uploadField.onchange = function () {
    const fileSizeLimit = 24 * 1024 * 1024;
    const file = this.files[0];

    if (file.size > fileSizeLimit) {
        alert("File is too big!");
        this.value = "";
    } else {
        readFiles(this);
    }
};

/**
 * Sets up the onload event handler for the FileReader object to handle the loaded file data.
 *
 * @param {Event} e - The event object that triggered the onload event.
 * @return {void} This function does not return anything.
 */
async function readFiles(input) {
    const previewsContainer = document.getElementById('previews');
    previewsContainer.innerHTML = '';

    for (const file of input.files) {
        const reader = new FileReader();

        await new Promise((resolve) => {

            /**
             * Sets up the onload event handler for the FileReader object to handle the loaded file data.
             *
             * @param {Event} e - The event object that triggered the onload event.
             * @return {void} This function does not return anything.
             */
            reader.onload = (e) => {
                const preview = document.createElement('img');

                if (file.type.startsWith('image/')) {
                    preview.src = e.target.result; // Display original image for image files
                } else {
                    switch (file.type) {
                        case 'application/pdf':
                            preview.src = '../images/pdf-thumbnail.svg';
                            break;
                        case file.type.match(/^video\//)?.input:
                            preview.src = '../images/thumbnail-video.svg';
                            break;
                        default:
                            // If it's not an image or known type, set a default thumbnail
                            preview.src = '../images/file-thumbnail.svg';
                            break;
                    }
                }

                previewsContainer.appendChild(preview);
                resolve();
            };

            reader.readAsDataURL(file);
        });
    }
}