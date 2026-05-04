function loadSelectedAdmin(adminId, currentUrl) {
    window.location.href = currentUrl.replace('#adminId#', encodeURIComponent(adminId));
}

function toggleHamburgerMenu() {
    let x = document.getElementById('hamburger-menu-container');
    if (x.style.display === 'block') {
        x.style.display = 'none';
    } else {
        x.style.display = 'block';
    }
}


document.addEventListener('DOMContentLoaded', () => {

    if (document.getElementById('performSearch') && document.getElementById('searchForm')) {
        document.getElementById('performSearch').addEventListener('click', function (event) {
            event.preventDefault()

            const formElement = document.getElementById('searchForm');
            let searchUrl = formElement.getAttribute('action') + '?';

            // we only want fields that have a value
            const formData = new FormData(formElement);

            let ctr = 0;
            formData.forEach((value, key) => {
                if (value && value.toString().trim() !== '') {
                    if (ctr > 0) searchUrl += '&';
                    searchUrl += key + '=' + encodeURIComponent(value.toString());
                    ctr++;
                }
            });

            window.location.href = searchUrl;
        });
    }

    // click the initial tab for tabbed content
    const tabElement = document.getElementById('initial-selected-tab');
    if (tabElement) {
        tabElement.click();
    }

    // delete header message button
    const headerMessageDeleteBtn= document.querySelector('div.message-header button.delete');
    if (headerMessageDeleteBtn) {
        headerMessageDeleteBtn.addEventListener('click', () => {
            document.getElementById('header-message-div').remove();
        });
    }

    // download link with prompt to rename the downloaded d file
    const downloadWLinksWithPromptBtns= document.querySelectorAll('.download-link-with-prompt');

    downloadWLinksWithPromptBtns.forEach((elem) => {
        elem.addEventListener('click', function(event) {
            event.preventDefault();

            // get the export url
            let downloadUrl = elem.getAttribute('data-href');
            if (!downloadUrl) {
                downloadUrl = elem.getAttribute('data-url');
            }

            // get the filename
            let filename = elem.getAttribute('data-filename');

            const link = document.createElement('a');
            link.href = downloadUrl;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
    });

    // excel export buttons
    const exportToExcelBtns= document.querySelectorAll('.export-to-excel-btn');
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

    const downloadResumeLinks= document.querySelectorAll('.resume-download');
    downloadResumeLinks.forEach((elem) => {
        elem.addEventListener('click', function() {

            // get the current download url and prompt the user for the name for the downloaded file
            let url = new URL(elem.getAttribute('href'));

            const params = {};
            url.searchParams.forEach((value, key) => {
                params[key] = value;
            });

            // prompt the user for the filename
            params.name = prompt('Please enter te name for the exported file:', elem.getAttribute('data-filename'));

            // generate the new url
            let newUrl =url.origin + url.pathname + '?';

            let i = 0;
            Object.keys(params).forEach(key => {
                if (i > 0) newUrl += '&';
                newUrl += key + '=' + encodeURIComponent(params[key]);
                i++;
            })

            elem.setAttribute('href', newUrl)
        })
    });

    const resumeTabs= document.querySelectorAll('.resume-tabs a');
    resumeTabs.forEach((elem) => {

        // hide inactive resume tabs
        document.querySelectorAll('#resume-tab-content .property-list').forEach((elem) => {
            elem.style.display = 'none';
        });
        document.querySelector('#resume-tab-content :first-child .property-list').style.display = 'flex';

        // add listeners to display is-active tabs
        elem.addEventListener('click', function() {
            const dataTarget = elem.parentElement.getAttribute('data-target');

            document.querySelectorAll('.resume-tabs ul li').forEach((elem) => {
                elem.classList.remove('is-active');
            });
            elem.parentElement.classList.add('is-active');

            document.querySelectorAll('#resume-tab-content .property-list').forEach((elem) => {
                elem.style.display = 'none';
            });

            document.querySelector(`#resume-tab-content > #${dataTarget} .property-list`).style.display = 'flex';
        });
    });

    // Functions to open and close a modal
    function openModal($el) {
        $el.classList.add('is-active');
    }

    function closeModal($el) {
        $el.classList.remove('is-active');
    }

    function closeAllModals() {
        (document.querySelectorAll('.modal') || []).forEach(($modal) => {
            closeModal($modal);
        });
    }

    // Add a click event on buttons to open a specific modal
    (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
        const modal = $trigger.dataset.target;
        const $target = document.getElementById(modal);

        $trigger.addEventListener('click', () => {
            openModal($target);
        });
    });

    // Add a click event on various child elements to close the parent modal
    (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
        const $target = $close.closest('.modal');

        $close.addEventListener('click', () => {
            closeModal($target);
        });
    });

    // Add a keyboard event to close all modals
    document.addEventListener('keydown', (event) => {
        if(event.key === "Escape") {
            closeAllModals();
        }
    });

});
