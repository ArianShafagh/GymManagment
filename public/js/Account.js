function showSection(sectionId, el) {
    var sections = document.querySelectorAll('.dashboard-section');
    var tabs = document.querySelectorAll('#dashboardTabs .list-group-item');
    var target = document.getElementById('section-' + sectionId);
    var healthProbCheckbox = document.getElementById('health_prob');
    var medicalNotesTextarea = document.getElementById('medical_notes');

    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = 'none';
    }

    if (target) {
        target.style.display = 'block';
    }

    for (var j = 0; j < tabs.length; j++) {
        tabs[j].classList.remove('active');
    }

    if (el) {
        el.classList.add('active');
    }

    if (healthProbCheckbox && medicalNotesTextarea) {
        medicalNotesTextarea.style.display = healthProbCheckbox.checked ? 'block' : 'none';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    var healthProbCheckbox = document.getElementById('health_prob');
    var medicalNotesTextarea = document.getElementById('medical_notes');
    var tabs = document.querySelectorAll('#dashboardTabs .list-group-item');
    var viewTicket = window.location.search.indexOf('view_ticket=') !== -1;

    if (healthProbCheckbox && medicalNotesTextarea) {
        healthProbCheckbox.onchange = function () {
            medicalNotesTextarea.style.display = this.checked ? 'block' : 'none';
        };

        medicalNotesTextarea.style.display = healthProbCheckbox.checked ? 'block' : 'none';
    }

    if (viewTicket && tabs[3]) {
        showSection('support', tabs[3]);
        return;
    }

    if (tabs[0]) {
        showSection('profile', tabs[0]);
    }
});