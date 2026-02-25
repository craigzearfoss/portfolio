async function downloadFile(url, filename) {
    // if the file is on a different domain then use downloadFileWithFetch() method
    console.log([ {url: url }, { filename: filename }])
    let link = document.createElement('a');
    link.href = url;
    link.style.display = 'none';
    if (filename) {
        link.download = filename
    }
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

async function downloadFileWithFetch(url, filename) {
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const blob = await response.blob(); // Get the response as a Blob object

        // Create a temporary URL for the Blob
        const blobUrl = URL.createObjectURL(blob);

        // Use the anchor method from Method 1
        const link = document.createElement('a');console.log('filename', filename)
        link.href = blobUrl;
        link.download = filename;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        // Clean up the object URL to free memory
        URL.revokeObjectURL(blobUrl);
    } catch (error) {
        console.error('File download failed:', error);
        // Handle potential CORS errors or network issues
    }
    /*
    // NOTE: this does not work when the file is on a different domain.
    let link = document.createElement('a');
    link.href = url;
    link.style.display = 'none';
    if (filename) {
        link.download = filename
        console.log('link.download = ' + link.download)
    }
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    */
}

document.addEventListener('DOMContentLoaded', function() {

    // Prompt to confirm with a delete button is clicked.
    const deleteButtons = document.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete?')) {
                button.form.submit();
            }
        });
    });

    // tabs
    const tabs = document.querySelectorAll('.tabs li');
    const tabContentBoxes = document.querySelectorAll('#tab-content > div');

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabs.forEach(item => item.classList.remove('is-active'));
            tab.classList.add('is-active');

            const target = tab.dataset.target;
            tabContentBoxes.forEach(box => {
                if (box.getAttribute('id') === target) {
                    box.classList.remove('is-hidden');
                } else {
                    box.classList.add('is-hidden');
                }
            })
        })
    })

});

