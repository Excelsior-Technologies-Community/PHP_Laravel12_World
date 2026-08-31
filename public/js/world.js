/* ===========================================================
   Laravel World - Frontend helpers
   - Dark mode toggle (persisted)
   - SweetAlert2 delete confirmation
   - Dependent dropdowns (Country -> States)
   =========================================================== */

(function () {
    'use strict';

    /* ---------- Dark Mode ---------- */
    const html = document.documentElement;
    const toggle = document.getElementById('themeToggle');

    function applyTheme(theme) {
        html.setAttribute('data-bs-theme', theme);
        if (toggle) {
            toggle.textContent = theme === 'dark' ? '☀️' : '🌙';
        }
    }

    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    if (toggle) {
        toggle.addEventListener('click', function () {
            const next = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            localStorage.setItem('theme', next);
            applyTheme(next);
        });
    }

    /* ---------- SweetAlert2 delete confirmation ---------- */
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (!form.classList.contains('form-delete')) {
            return;
        }

        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This record will be moved to trash (soft delete).',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    /* ---------- Dependent dropdown: Country -> States ---------- */
    function loadStates(countrySelect, stateSelect, selectedStateId) {
        const countryId = countrySelect.value;

        if (!countryId) {
            stateSelect.innerHTML = '<option value="">-- Select State --</option>';
            return;
        }

        fetch('/states/by-country/' + countryId)
            .then((res) => res.json())
            .then((states) => {
                let html = '<option value="">-- Select State --</option>';
                states.forEach(function (state) {
                    const selected = selectedStateId && String(state.id) === String(selectedStateId)
                        ? ' selected' : '';
                    html += '<option value="' + state.id + '"' + selected + '>' + state.name + '</option>';
                });
                stateSelect.innerHTML = html;
            });
    }

    document.querySelectorAll('[data-country-select]').forEach(function (countrySelect) {
        const stateSelect = document.querySelector(countrySelect.getAttribute('data-country-select'));

        if (!stateSelect) {
            return;
        }

        countrySelect.addEventListener('change', function () {
            loadStates(countrySelect, stateSelect, null);
        });

        // Pre-load states if a country is already selected (edit / validation fail)
        if (countrySelect.value) {
            const preselected = stateSelect.getAttribute('data-selected-state') || null;
            loadStates(countrySelect, stateSelect, preselected);
        }
    });
})();
