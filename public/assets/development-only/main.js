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
        button.addEventListener('click', function () {
            if (confirm('Are you sure you want to delete?')) {
                button.form.submit();
            }
        });
    });

});
