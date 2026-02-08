function downloadFile(url, filename) {
    // NOTE: this does not work when the file is on a different domain.
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

