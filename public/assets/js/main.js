function loadSelectedAdmin(adminId, currentUrl) {
    window.location.href = currentUrl.replace('#adminId#', encodeURIComponent(adminId));
}
