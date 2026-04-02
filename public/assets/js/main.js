function loadSelectedAdmin(adminId, currentUrl) {
    window.location.href = currentUrl.replace('#adminId#', encodeURIComponent(adminId));
}

function toggleHamburgerMenu() {
    let x = document.getElementById("hamburger-menu-container");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
}


document.addEventListener("DOMContentLoaded", () => {

    if (document.getElementById("performSearch")) {
        document.getElementById("performSearch").addEventListener("click", function (event) {
            document.getElementById("searchForm").submit();
        });
    }

    // click the initial tab for tabbed content
    const tabElement = document.getElementById('initial-selected-tab');
    if (tabElement) {
        tabElement.click();
    }
});
