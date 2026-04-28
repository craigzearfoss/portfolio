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
        document.getElementById("performSearch").addEventListener("click", function () {
            document.getElementById("searchForm").submit();
        });
    }

    // click the initial tab for tabbed content
    const tabElement = document.getElementById('initial-selected-tab');
    if (tabElement) {
        tabElement.click();
    }

    // delete header message button
    const headerMessageDeleteBtn= document.querySelector("div.message-header button.delete");
    if (headerMessageDeleteBtn) {
        headerMessageDeleteBtn.addEventListener('click', () => {
            document.getElementById('header-message-div').remove();
        });
    }

    const exportToExcelBtns= document.querySelectorAll(".export-to-excel-btn");
    exportToExcelBtns.forEach((elem) => {
        elem.addEventListener('click', function(event) {
            event.preventDefault();

            // get the export url
            let exportUrl = elem.getAttribute('data-href');
            if (!exportUrl) {
                exportUrl = elem.getAttribute('href');
            }
            if (!exportUrl) {
                window.location.href + '/export?timestamp';
            }

            // get the filename
            let filename = elem.getAttribute('data-filename');
            if (!filename) {
                filename = 'file.xlsx';
            }

            const link = document.createElement('a');
            link.href = exportUrl;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
    });

    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#inputPassword');

    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            // Toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle the eye / eye-slash icon
            this.classList.toggle('fa-eye-slash');
        });
    }

    const downloadResumeLinks= document.querySelectorAll(".resume-download");
    downloadResumeLinks.forEach((elem) => {
        elem.addEventListener('click', function() {

            // get the current download url and prompt the user for the name for the downloaded file
            let url = new URL(elem.getAttribute('href'));

            const params = {};
            url.searchParams.forEach((value, key) => {
                params[key] = value;
            });

            // prompt the user for the filename
            params.name = prompt("Please enter te name for the exported file:", elem.getAttribute('data-filename'));

            // generate the new url
            let newUrl =url.origin + url.pathname + "?";

            let i = 0;
            Object.keys(params).forEach(key => {
                if (i > 0) newUrl += '&';
                newUrl += key + '=' + encodeURIComponent(params[key]);
                i++;
            })

            elem.setAttribute("href", newUrl)
        })
    });

    const resumeTabs= document.querySelectorAll(".resume-tabs a");
    resumeTabs.forEach((elem) => {

        // hide inactive resume tabs
        document.querySelectorAll("#resume-tab-content .property-list").forEach((elem) => {
            console.log(elem);
            elem.style.display = "none";
        });
        document.querySelector("#resume-tab-content :first-child .property-list").style.display = "flex";

        // add listeners to display is-active tabs
        elem.addEventListener('click', function() {
            const dataTarget = elem.parentElement.getAttribute("data-target");

            document.querySelectorAll(".resume-tabs ul li").forEach((elem) => {
                elem.classList.remove('is-active');
            });
            elem.parentElement.classList.add("is-active");

            document.querySelectorAll("#resume-tab-content .property-list").forEach((elem) => {
                console.log(elem);
                elem.style.display = "none";
            });

            document.querySelector(`#resume-tab-content > #${dataTarget} .property-list`).style.display = "flex";
        });
    });

});
