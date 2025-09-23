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
