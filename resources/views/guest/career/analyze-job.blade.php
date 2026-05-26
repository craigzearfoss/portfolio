@php
    // make sure all template variables are defined (this is mostly for the IDE parser)
    $className        = 'App\Models\Portfolio\Art';
    $owner            = $owner ?? null;
    $publicAdminCount = $publicAdminCount ?? 0;

    $title    = 'Job Analyzer';
    $subtitle = $title;

    // set breadcrumbs
    $breadcrumbs = [
        [ 'name' => 'Home', 'href' => route('guest.index') ],
        [ 'name' => 'Analyze Job' ],
    ];

    // set navigation buttons
    $navButtons = [];
@endphp

@extends('guest.layouts.default')

@section('content')

    <div id="modal-add-skills" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <h2 class="subtitle mb-0">Add Skill(s)</h2>
                <p>
                    Add a comma-separated list of skills that you want to match.
                </p>
                @include('admin.components.input', [
                    'id'    => 'skills-list',
                    'name'  => 'skills_list',
                    'value' => '',
                    'class' => 'p-0 mt-1 mb-1',
                    'style' => 'height: 1. 8rem',
                ])
                <div class="mt-1 pb-4" >
                    <span style="float: right;">
                        @include('admin.components.nav-button', [
                            'id'    => 'submit-add-skills-modal-button',
                            'name'  => 'Add',
                            'class' => 'submit-add-skills-modal button is-small is-dark'
                        ])
                    </span>
                    <span style="float: right;">
                        @include('admin.components.nav-button', [
                            'id'    => 'cancel-add-skills-modal-button',
                            'name'  => 'Cancel',
                            'class' => 'cancel-add-skills-modal button is-small is-dark mr-1'
                        ])
                    </span>
                </div>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>

    <div id="modal-add-anti-skills" class="modal">
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="box">
                <h2 class="subtitle mb-0">Add Anti-Skill(s)</h2>
                <p>
                    Add a comma-separated list of skills that you do NOT want to match.
                </p>
                @include('admin.components.input', [
                    'name'  => 'anti_skills_list',
                    'id'    => 'anti-skills-list',
                    'value' => '',
                    'class' => 'p-0 mt-1 mb-1',
                    'style' => 'height: 1. 8rem',
                ])
                <div class="mt-1 pb-4" >
                    <span style="float: right;">
                        @include('admin.components.nav-button', [
                            'id'    => 'submit-add-anti-skills-modal-button',
                            'name'  => 'Add',
                            'class' => 'submit-add-anti-skills-modal button is-small is-dark'
                        ])
                    </span>
                    <span style="float: right;">
                        @include('admin.components.nav-button', [
                            'id'    => 'cancel-add-anti-skills-modal-button',
                            'name'  => 'Cancel',
                            'class' => 'cancel-add-anti-skills-modal button is-small is-dark mr-1'
                        ])
                    </span>
                </div>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close"></button>
    </div>

    <section class="section pt-0">

        <div class="container show-container analyze-job-container ml-0" style="max-width: 60rem;">

            <div class="p-4">

                <p class="mb-2">
                    This page allows to examine a job description by searching for matching skills. It is not a
                    comprehensive way to analyze a job, but it can quickly give an idea if there
                    is enough of a match for you to investigate the job farther.
                </p>
                <p class="mb-0">
                    To use this page:
                </p>
                <ol class="ml-4 mb-4 pl-4">
                    <li>
                        Add the skills that you want to match and "anti-skills" which are skills
                        that you don't want to match because you do not have them.
                    </li>
                    <li>
                        Check the skill and anti-skills that you want to use in the search.
                    </li>
                    <li>
                        Then copy the job description into the text area and click on the "Analyze" button.
                    </li>
                </ol>

                <form action="{{ route('admin.career.application.analyze-post') }}" method="post">
                    @csrf

                    <div class="card job-analyzer-skill-list">
                        <div class="card-header">
                            <div style="width: 100%;">
                                <label for="add-skills-button">
                                    Skills
                                </label>
                                <i id="skillMatchCountMsg"></i>
                                <button type="button"
                                        id="add-skills-button"
                                        class="skill-modal-trigger hide-when-analyzed"
                                        data-target="modal-add-skills"
                                >Add Skill(s)</button>
                                <button type="button"
                                        id="unselect-all-skills-button"
                                        class="select-all-skills hide-when-analyzed"
                                >Unselect All</button>
                                <button type="button"
                                        id="select-all-skills-button"
                                        class="select-all-skills hide-when-analyzed"
                                >Select All</button>
                            </div>
                        </div>
                        <div id="skill-list" class="card-body p-2">
                        </div>
                    </div>

                    <div class="card job-analyzer-skill-list">
                        <div class="card-header">
                            <div style="width: 100%;">
                                <label for="add_anti_skills_button">
                                    Anti-Skills
                                </label>
                                <i id="antiSkillMatchCountMsg"></i>
                                <button type="button"
                                        id="add-anti-skills-button"
                                        class="anti-skill-modal-trigger hide-when-analyzed"
                                        data-target="modal-add-anti-skills"
                                >Add Anti-Skill(s)</button>
                                <button type="button"
                                        id="unselect-all-anti-skills-button"
                                        class="select-all-skills hide-when-analyzed"
                                >Unselect All</button>
                                <button type="button"
                                        id="select-all-anti-skills-button"
                                        class="select-all-skills hide-when-analyzed"
                                >Select All</button>
                            </div>
                        </div>
                        <div id="anti-skill-list" class="card-body p-2">
                        </div>
                    </div>

                    <div class="mt-4">
                        <span>Paste the job description in the text box below and click on the "Analyze" button.</span>
                        <span class="has-text-right" style="float: right;">
                            <button type="button" id="submitAnalyze" class="button is-small is-dark">
                                <i class="fa fa-floppy-disk"></i>
                                Analyze
                            </button>
                        </span>
                        <span class="has-text-right mr-2" style="float: right;">
                            <button id="clearJobDescription" type="button" class="button hide-when-analyzed is-small is-dark">
                                <i class="fa fa-eraser"></i>
                                Clear Description
                            </button>
                        </span>
                        <span class="has-text-right mr-2" style="float: right;">
                            <button id="resetJobAnalyzer" type="button" class="button show-when-analyzed is-small is-dark" style="display: none;">
                                <i class="fa fa-eraser"></i>
                                Reset
                            </button>
                        </span>
                    </div>

                    <div id="source-job-description">
                        @include('guest.components.form-textarea', [
                            'name'  => 'description',
                            'id'    => 'inputEditor',
                            'label' => '',
                            'value' => '',
                            'rows'  => 10,
                            'class' => 'analyze-job-description',
                        ])
                    </div>
                    <div id="analyzed-job-description" style="display: none;">
                    </div>

                </form>

            </div>

        </div>

    </section>

    <script>

        document.addEventListener('DOMContentLoaded', () => {

            let allSkills = {};
            let allAntiSkills = {};

            let skillMatchCount = 0;
            let antiSkillMatchCount = 0;

            function getSkillSlug(skill)
            {
                return skill.toLowerCase().replace(' ', '-');
            }

            function initializeSkills() {

                // get all skills
                allSkills = localStorage.getItem('allSkills');
                if (allSkills) {
                    allSkills = JSON.parse(allSkills);
                } else {
                    allSkills = {};
                }
                localStorage.setItem('allSkills', JSON.stringify(allSkills));

                // create skill checkboxes
                Object.entries(allSkills).forEach(([skill, value]) => {
                    addSkillCheckbox('skill', skill, value);
                });
            }

            function initializeAntiSkills() {

                // get all anti-skills
                allAntiSkills = localStorage.getItem('allAntiSkills');
                if (allAntiSkills) {
                    allAntiSkills = JSON.parse(allAntiSkills);
                } else {
                    allAntiSkills = {};
                }
                localStorage.setItem('allAntiSkills', JSON.stringify(allAntiSkills));

                // create anti-skill checkboxes
                Object.entries(allAntiSkills).forEach(([antiSkill, value]) => {
                    addSkillCheckbox('anti-skill', antiSkill, value);
                });
            }

            function checkSkill(checkboxElem)
            {
                const type = checkboxElem.getAttribute('data-type');

                checkboxElem.checked = true;
                if (type === 'anti-skill') {
                    if (allAntiSkills.hasOwnProperty(checkboxElem.value)) {
                        allAntiSkills[checkboxElem.value] = true;
                        localStorage.setItem('allAntiSkills', JSON.stringify(allAntiSkills));
                    }
                } else {
                    if (allSkills.hasOwnProperty(checkboxElem.value)) {
                        allSkills[checkboxElem.value] = true;
                        localStorage.setItem('allSkills', JSON.stringify(allSkills));
                    }
                }
            }

            function uncheckSkill(checkboxElem)
            {
                const type = checkboxElem.getAttribute('data-type');

                checkboxElem.checked = false;
                if (type === 'anti-skill') {
                    if (allAntiSkills.hasOwnProperty(checkboxElem.value)) {
                        allAntiSkills[checkboxElem.value] = false;
                        localStorage.setItem('allAntiSkills', JSON.stringify(allAntiSkills));
                    }
                } else {
                    if (allSkills.hasOwnProperty(checkboxElem.value)) {
                        allSkills[checkboxElem.value] = false;
                        localStorage.setItem('allSkills', JSON.stringify(allSkills));
                    }
                }
            }

            function addSkill(type, skill, value)
            {
                if (type === 'anti-skill') {
                    allAntiSkills[skill] = value;
                    localStorage.setItem('allAntiSkills', JSON.stringify(allAntiSkills));
                } else {
                    allSkills[skill] = value;
                    localStorage.setItem('allSkills', JSON.stringify(allSkills));
                }

                addSkillCheckbox(type, skill, value)
            }

            function addSkills(type, skills)
            {
                skills.forEach((skill) => {
                    if (!Object.keys(allSkills).includes(skill)) addSkill(type, skill, true);
                });
            }

            function removeSkill(type, skill)
            {
                if (type === 'anti-skill') {
                    if (allAntiSkills.hasOwnProperty(skill)) {
                        delete allAntiSkills[skill];
                    }
                    localStorage.setItem('allAntiSkills', JSON.stringify(allAntiSkills));
                } else {
                    if (allSkills.hasOwnProperty(skill)) {
                        delete allSkills[skill];
                    }
                    localStorage.setItem('allSkills', JSON.stringify(allSkills));
                }
                removeSkillCheckbox(type, skill)
            }

            function checkboxClicked(checkboxElem)
            {
                const type = checkboxElem.getAttribute('data-type');
                const skill = checkboxElem.value;

                if (type === 'anti-skill') {
                    if (allAntiSkills.hasOwnProperty(skill)) {
                        allAntiSkills[skill] = checkboxElem.checked;
                        localStorage.setItem('allAntiSkills', JSON.stringify(allAntiSkills));
                    }
                } else {
                    if (allSkills.hasOwnProperty(skill)) {
                        allSkills[skill] = checkboxElem.checked;
                        localStorage.setItem('allSkills', JSON.stringify(allSkills));
                    }
                }
            }

            function addSkillCheckbox(type, skill, isChecked = false)
            {
                const skillSlug = getSkillSlug(skill);

                let checkmarkElem = document.createElement('i');
                checkmarkElem.className = `skill-checkbox-icon ${type}-checkmark show-when-analyzed fa ml-2`;
                checkmarkElem.setAttribute('data-type', type);
                checkmarkElem.setAttribute('data-skill', skill);
                checkmarkElem.style.width = '20px';
                checkmarkElem.style.display = 'none';

                let checkboxElem = document.createElement('input');
                checkboxElem.setAttribute('type', 'checkbox');
                checkboxElem.setAttribute('id', 'checkBoxSkill_' + skill.toLowerCase().replace(' ', '-'));
                checkboxElem.setAttribute('name', 'skill[]');
                checkboxElem.setAttribute('value', skill);
                if (isChecked) {
                    checkboxElem.setAttribute('checked', 'checked');
                }
                checkboxElem.className = `${type}-checkbox hide-when-analyzed form-check-input`;
                checkboxElem.setAttribute('data-type', type);
                checkboxElem.addEventListener('click', (event) => {
                    checkboxClicked(event.target);
                });

                let inputDivElem = document.createElement('div');
                inputDivElem.appendChild(checkmarkElem);
                inputDivElem.appendChild(checkboxElem);

                let labelName = document.createElement('span');
                labelName.innerHTML = skill;

                let labelElem = document.createElement('label');
                labelElem.setAttribute('for', `checkBoxSkill_${skillSlug}`);
                labelElem.className = 'ml-1';
                labelElem.appendChild(labelName);

                let rowElem = document.createElement('div');
                rowElem.setAttribute('id', `${type}-${skillSlug}-container`)
                rowElem.className = 'analyze-job-skill-div';
                rowElem.appendChild(inputDivElem);
                rowElem.appendChild(labelElem)

                let removeSkillIcon = document.createElement('i');
                removeSkillIcon.className = 'fa fa-close hide-when-analyzed remove-skill';
                removeSkillIcon.setAttribute('data-type', type)
                removeSkillIcon.setAttribute('data-skill', skill)
                removeSkillIcon.addEventListener('click', (event) => {
                    const elem = event.target;
                    const type = elem.getAttribute('data-type');
                    const skill = elem.getAttribute('data-skill');
                    removeSkill(type, skill);
                });

                rowElem.appendChild(removeSkillIcon)

                document.getElementById(`${type}-list`).appendChild(rowElem);
            }

            function removeSkillCheckbox(type, skill)
            {
                const skillSlug = getSkillSlug(skill);
                const elem = document.getElementById(`${type}-${skillSlug}-container`);
                if (elem) {
                    elem.remove();
                }
            }

            function getMatchingSkillNames(skill)
            {
                let skillNames = [ skill ];
                switch (skill.toLowerCase()) {
                    case '401(k)':
                        skillNames.push('401k');
                        break;
                    case '401k':
                        skillNames.push('401(k)');
                        break;
                    case 'angular':
                        skillNames.push('angularjs');
                        break;
                    case 'angularjs':
                        skillNames.push('angular');
                        break;
                    case 'claude':
                        skillNames.push('claude code');
                        break;
                    case 'claude code':
                        skillNames.push('claude');
                        break;
                    case 'devop':
                        skillNames.push('devops');
                        break;
                    case 'devops':
                        skillNames.push('devop');
                        break;
                    case 'git':
                        skillNames.push('github');
                        break;
                    case 'github':
                        skillNames.push('git');
                        break;
                    case 'llm':
                        skillNames.push('llms');
                        break;
                    case 'llms':
                        skillNames.push('llm');
                        break;
                    case 'postgresql':
                        skillNames.push('postgres');
                        break;
                    case 'rest':
                        skillNames.push('restful');
                        break;
                    case 'restful':
                        skillNames.push('rest');
                        break;
                    case 'ruby on rails':
                        skillNames.push('ruby');
                        break;
                    case 'ui':
                        skillNames.push('ux');
                        skillNames.push('ux/ui');
                        break;
                    case 'ux':
                        skillNames.push('ui');
                        skillNames.push('ux/ui');
                        break;
                    case 'ux/ui':
                        skillNames.push('ui');
                        skillNames.push('ux');
                        break;
                }

                // if the skill ends in a number then include the skill with a number
                if (skill.includes('.') && skill.split('.')[0].trimEnd().length > 1) {
                    skillNames.push(skill.split('.')[0].trimEnd());
                } else if (/\d$/.test(skill)) {
                    if (![ 'ec2', 's3', ].includes(skill.toLowerCase())) {
                        let skillWithoutVersion = skill.replace(/\d+$/, '');
                        skillNames.push(skillWithoutVersion.trimEnd());
                    }
               }

                return skillNames;
            }

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

            initializeSkills();
            initializeAntiSkills();

            (document.querySelectorAll('.skill-modal-trigger') || []).forEach(($trigger) => {
                const modal = $trigger.dataset.target;
                const $target = document.getElementById(modal);

                $trigger.addEventListener('click', () => {
                    openModal($target);
                });
            });

            (document.querySelectorAll('.anti-skill-modal-trigger') || []).forEach(($trigger) => {
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

            document.getElementById('cancel-add-skills-modal-button').addEventListener('click', () => {
                 document.getElementById('skills-list').value = '';
                 closeModal(document.getElementById('modal-add-skills'));
            });

            document.getElementById('cancel-add-anti-skills-modal-button').addEventListener('click', () => {
                document.getElementById('anti-skills-list').value = '';
                closeModal(document.getElementById('modal-add-anti-skills'));
            });

            document.getElementById('submit-add-skills-modal-button').addEventListener('click', () => {
                let skillsStr = document.getElementById('skills-list').value.trim();
                if (skillsStr) {
                    let skills = skillsStr.split(',').map((skill) => {
                        return skill.trim();
                    });
                    addSkills('skill', skills);
                }
                document.getElementById('skills-list').value = '';
                closeModal(document.getElementById('modal-add-skills'));
            });

            document.getElementById('submit-add-anti-skills-modal-button').addEventListener('click', () => {
                let antiSkillsStr = document.getElementById('anti-skills-list').value.trim();
                if (antiSkillsStr) {
                    let antiSkills = antiSkillsStr.split(',').map((antiSkill) => {
                        return antiSkill.trim();
                    });
                    addSkills('anti-skill', antiSkills);
                }
                document.getElementById('anti-skills-list').value = '';
                closeModal(document.getElementById('modal-add-anti-skills'));
            });

            document.getElementById('unselect-all-skills-button').addEventListener('click', () => {
                (document.querySelectorAll('input[type="checkbox"].skill-checkbox') || []).forEach(checkboxElem => {
                    uncheckSkill(checkboxElem);
                });
            });

            document.getElementById('select-all-skills-button').addEventListener('click', () => {
                (document.querySelectorAll('input[type="checkbox"].skill-checkbox') || []).forEach(checkboxElem => {
                    checkSkill(checkboxElem);
                });
            });

            document.getElementById('unselect-all-anti-skills-button').addEventListener('click', () => {
                (document.querySelectorAll('input[type="checkbox"].anti-skill-checkbox') || []).forEach(checkboxElem => {
                    uncheckSkill(checkboxElem);
                });
            });

            document.getElementById('select-all-anti-skills-button').addEventListener('click', () => {
                (document.querySelectorAll('input[type="checkbox"].anti-skill-checkbox') || []).forEach(checkboxElem => {
                    checkSkill(checkboxElem);
                });
            })

            document.getElementById('clearJobDescription').addEventListener('click', () => {

                document.getElementById('skillMatchCountMsg').innerHTML = '';
                document.getElementById('antiSkillMatchCountMsg').innerHTML = '';

                window.editor.setData('');
                document.getElementById('source-job-description').style.display = 'block';
                document.getElementById('analyzed-job-description').innerHTML = '';
                document.getElementById('analyzed-job-description').style.display = 'none';
            });

            document.getElementById('resetJobAnalyzer').addEventListener('click', () => {

                skillMatchCount = 0;
                antiSkillMatchCount = 0;

                document.querySelectorAll('.hide-when-analyzed').forEach((elem) => {
                    elem.style.display = 'inline-block'
                });

                document.querySelectorAll('.show-when-analyzed').forEach((elem) => {
                    elem.style.display = 'none'
                });

                document.getElementById('submitAnalyze').removeAttribute('disabled');

                (document.querySelectorAll('.skill-checkbox-icon') || []).forEach((elem) => {
                    elem.classList.remove('fa-check');
                });

                document.getElementById('skillMatchCountMsg').innerHTML = '';
                document.getElementById('antiSkillMatchCountMsg').innerHTML = '';
            });

            document.getElementById('submitAnalyze').addEventListener('click', (event) => {

                if (window.editor.getData().trim() === '') {

                    alert('Please paste the job description.');

                } else {

                    let elem = event.target;

                    let skillMatchCount = 0;
                    let antiSkillMatchCount = 0;

                    document.getElementById('source-job-description').style.display = 'none';

                    let description = window.editor.getData();

                    // search for skill matches
                    Object.entries(allSkills).forEach(([skill, value]) => {
                        if ((value)) {

                            let skillMatchFound = false;

                            const skillNames = getMatchingSkillNames(skill);
                            for (let i=0; i<skillNames.length; i++) {

                                let regex = new RegExp('[^\ba-zA-Z0-9]' + skillNames[i] + '[^\ba-zA-Z0-9]', 'gi');

                                const skillMatches = Array.from(description.matchAll(regex));
                                if (skillMatches.length) {

                                    skillMatchFound = true;

                                    // display the check icon for the skill
                                    const skillCheckmark = document.querySelector(`i.skill-checkbox-icon[data-type="skill"][data-skill="${skill}"]`);
                                    if (skillCheckmark) {
                                        skillCheckmark.classList.add('fa-check');
                                    }

                                    // mark the matches in the description (note that we iterate through the array in reverse)
                                    for (let j = skillMatches.length - 1; j >= 0; j--) {
                                        let offset = skillMatches[j][0].toLowerCase().indexOf(skillNames[i].toLowerCase());
                                        let startPos = skillMatches[j].index + offset;
                                        let endPos = startPos + skillNames[i].length - 1;
                                        let replaceStr = skillMatches[j][0].substring(offset, skillNames[i].length + offset);

                                        /*
                                        console.log('skill: "' + skill + '"' +"\n"
                                            + 'match: "' + skillMatches[j][0] + '"' + "\n"
                                            + 'index: "' + skillMatches[j].index + '"' + "\n"
                                            + 'offset: "' + offset + '"' + "\n"
                                            + 'startPos: ' + startPos + "\n"
                                            + 'endPos: ' + endPos + "\n"
                                            + 'replaceStr: "' + replaceStr + '"' + "\n"
                                            + 'start: "' + skillMatches[j].index + "\n"
                                            + 'end: "' + endPos
                                        );
                                        */

                                        description = description.slice(0, startPos)
                                            + `<strong class="has-text-success">${replaceStr}</strong>`
                                            + description.slice(endPos + 1)
                                    }
                                }
                            }

                            if (skillMatchFound) {
                                skillMatchCount++;
                            }
                        }
                    });

                    // search for anti-skill matches
                    Object.entries(allAntiSkills).forEach(([antiSkill, value]) => {
                        if ((value)) {

                            let antiSkillMatchFound = false;

                            const antiSkillNames = getMatchingSkillNames(antiSkill);
                            for (let i=0; i<antiSkillNames.length; i++) {

                                let regex = new RegExp('[^\ba-zA-Z0-9]' + antiSkillNames[i] + '[^\ba-zA-Z0-9]', 'gi');

                                const antiSkillMatches = Array.from(description.matchAll(regex));
                                if (antiSkillMatches.length) {

                                    antiSkillMatchFound = true;

                                    // display the check icon for the anti-skill
                                    const antiSkillCheckmark = document.querySelector(`i.skill-checkbox-icon[data-type="anti-skill"][data-skill="${antiSkill}"]`);
                                    if (antiSkillCheckmark) {
                                        antiSkillCheckmark.classList.add('fa-check');
                                    }

                                    // mark the matches in the description (note that we iterate through the array in reverse)
                                    for (let j = antiSkillMatches.length - 1; j >= 0; j--) {
                                        let offset = antiSkillMatches[j][0].toLowerCase().indexOf(antiSkillNames[i].toLowerCase());
                                        let startPos = antiSkillMatches[j].index + offset;
                                        let endPos = startPos + antiSkillNames[i].length - 1;
                                        let replaceStr = antiSkillMatches[j][0].substring(offset, antiSkillNames[i].length + offset);

                                        /*
                                        console.log('anti-skill: "' + antiSkill + '"' +"\n"
                                            + 'match: "' + antiSkillMatches[j][0] + '"' + "\n"
                                            + 'index: "' + antiSkillMatches[j].index + '"' + "\n"
                                            + 'offset: "' + offset + '"' + "\n"
                                            + 'startPos: ' + startPos + "\n"
                                            + 'endPos: ' + endPos + "\n"
                                            + 'replaceStr: "' + replaceStr + '"' + "\n"
                                            + 'start: "' + antiSkillMatches[j].index + "\n"
                                            + 'end: "' + endPos
                                        );
                                        */

                                        description = description.slice(0, startPos)
                                            + `<strong class="has-text-danger">${replaceStr}</strong>`
                                            + description.slice(endPos + 1)
                                    }
                                }
                            }

                            if (antiSkillMatchFound) {
                                antiSkillMatchCount++;
                            }
                        }
                    });

                    document.getElementById('skillMatchCountMsg').innerHTML = ' - '
                        + skillMatchCount + ' of ' + allSkills.length
                        + ((skillMatchCount === 1) ? ' skill matched.' : ' skills matched.');
                    document.getElementById('antiSkillMatchCountMsg').innerHTML = ' - '
                        + antiSkillMatchCount + ' of ' + allAntiSkills.length
                        + ((antiSkillMatchCount === 1) ? ' anti-skill matched.' : ' anti-skills matched.');

                    document.getElementById('analyzed-job-description').innerHTML = description;
                    document.getElementById('analyzed-job-description').style.display = 'block';

                    document.querySelectorAll('.skill-checkbox').forEach((checkboxElem) => {
                        checkboxElem.style.display = 'none'
                    });

                    document.querySelectorAll('.skill-checkmark').forEach((checkmarkElem) => {
                        checkmarkElem.style.display = 'inline-block'
                    });

                    document.querySelectorAll('.anti-skill-checkbox').forEach((checkboxElem) => {
                        checkboxElem.style.display = 'none'
                    });

                    document.querySelectorAll('.anti-skill-checkmark').forEach((checkmarkElem) => {
                        checkmarkElem.style.display = 'inline-block'
                    });

                    // hide or show appropriate elements
                    document.querySelectorAll('.hide-when-analyzed').forEach((elem) => {
                        elem.style.display = 'none'
                    });
                    document.querySelectorAll('.show-when-analyzed').forEach((elem) => {
                        elem.style.display = 'inline-block'
                    });

                    elem.setAttribute('disabled', 'disabled');
                }
            });
        });

    </script>

@endsection
