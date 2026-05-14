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

async function postDataToUrl(url = '', data = {}) {
    const response = await fetch(url, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data),
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
}

async function fetchUrl(url = '') {
    const response = await fetch(url, {
        method: 'GET',
        headers: {
            "Content-Type": "application/json",
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    });

    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }

    return response.json();
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
    const headerMessageDeleteButton= document.querySelector('div.message-header button.delete');
    if (headerMessageDeleteButton) {
        headerMessageDeleteButton.addEventListener('click', () => {
            document.getElementById('header-message-div').remove();
        });
    }

    // download link with prompt to rename the downloaded d file
    const downloadLinksWithPromptButtons= document.querySelectorAll('.download-link-with-prompt');

    downloadLinksWithPromptButtons.forEach((elem) => {
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
    const exportToExcelButtons= document.querySelectorAll('.export-to-excel-btn');
    exportToExcelButtons.forEach((elem) => {
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

    // application resume select
    const applicationResumeSelect = document.getElementById('application-select-resume');
    if (applicationResumeSelect) {
        applicationResumeSelect.addEventListener('change', (event) => {
            const selectListElem = event.target;
            const currentResumeId = selectListElem.getAttribute('data-current-resume-id')
            const selectedOption = selectListElem.selectedOptions[0]

            const resumeId = selectedOption.getAttribute('data-id');
            const href = selectedOption.getAttribute('data-href');

            const previewIframeElem = document.getElementById('application-resume-preview');

            // show/hide the preview iframe
            if (href) {
                previewIframeElem.style.display = 'block';
            } else {
                previewIframeElem.style.display = 'none';
            }

            previewIframeElem.setAttribute('src', href);

            // show/hide the attach button
            if (resumeId && (resumeId !== currentResumeId)) {
                document.getElementById('attach-resume-button').style.display = 'inline-block';
            } else {
                document.getElementById('attach-resume-button').style.display = 'none';
            }

            if (resumeId === currentResumeId) {
                document.getElementById('attach-resume-button').style.display = 'none';
            } else {
                document.getElementById('attach-resume-button').style.display = 'inline-block';
            }
        });
    }

    const allActiveResumesButton = document.getElementById('all_active_resumes');
    if (allActiveResumesButton) {
        allActiveResumesButton.addEventListener('click',  (event) => {
            let elem = event.target

           const btnText = elem.innerText;
            if (btnText === 'Show All Resumes') {
                elem.innerText = 'Show Only Active Resumes';
                elem. setAttribute('title', 'show only active resumes')
                document.querySelectorAll('#application-select-resume option').forEach((optionElem) => {
                    optionElem.style.display = 'block';
                });
            } else {
                elem.innerText = 'Show All Resumes';
                elem. setAttribute('title', 'show all resumes')
                document.querySelectorAll('#application-select-resume option').forEach((optionElem) => {
                    if (parseInt(optionElem.getAttribute('data-active'))) {
                        optionElem.style.display = 'block';
                    } else {
                        optionElem.style.display = 'none';
                    }
                });
            }
            document.getElementById('application-select-resume').selectedIndex = -1;
            document.getElementById('attach-resume-button').style.display = 'inline-block';
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

    const applicationSkillCheckboxes= document.querySelectorAll('.application-skill-checkbox');
    applicationSkillCheckboxes.forEach((elem) => {
        elem.addEventListener('click', function(event) {
            let checkbox = event.target;

            const applicationId = checkbox.getAttribute('data-application_id');
            const applicationSkillId = checkbox.getAttribute('data-application_skill_id');

            let dataForPost = {

                name: checkbox.getAttribute('data-name'),
                application_skill_id: checkbox.getAttribute('application_skill_id'),
                portfolio_skill_id: checkbox.getAttribute('portfolio_skill_id'),
            };

            if (checkbox.checked) {

                postDataToUrl(`/admin/career/application/${applicationId}/add-skill`, dataForPost)
                    .then((data) => {
                        if (!data.success) {
                            console.log(data)
                            alert(data.message ?? 'Skill could not be added.');
                            elem.checked = false;
                        }
                    })
                    .catch((error) => console.error('Error:', error));

            } else {

                fetchUrl(`/admin/career/application/${applicationId}/remove-skill/${applicationSkillId}`)
                    .then((data) => {
                        if (!data.success) {
                            console.log(data)
                            alert(data.message ?? 'Skill could not be removed.');
                            elem.checked = true;
                        }
                    })
                    .catch((error) => console.error('Error:', error));
            }
        });
    });

    if (window.editor) {
        window.editor.model.document.on('change:data', () => {
            console.log('The document has changed!');
            if (document.getElementById('inputDescriptionChanged')) {
                document.getElementById('inputDescriptionChanged').value = 1;
            }
        });
    }

    document.querySelectorAll('form input[name="description"]').forEach((elem) => {
        elem.addEventListener('input', () =>  {
            console.log('description changed');
            let inputDescriptionChangedElem = document.getElementById('inputDescriptionChanged');
            if (inputDescriptionChangedElem) {
                inputDescriptionChangedElem.value = 1;
            }
        });
    });

    const clearAnalyzeApplicationDescription = document.getElementById('clearAnalyzeApplicationDescription');
    if (clearAnalyzeApplicationDescription) {
        document.getElementById('clearAnalyzeApplicationDescription').addEventListener('click', () => {
            document.querySelectorAll('.analyze-application-description').forEach(() => {
                window.editor.setData('');
            });
        })
    }
});
