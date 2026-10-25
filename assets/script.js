// Frontend helpers only. Your task is to implement the security checks in PHP.
const fileInput = document.getElementById('fileUpload');

fileInput?.addEventListener('change', () => {
    const file = fileInput.files[0];
    document.getElementById('selected-file').textContent = file
        ? `${file.name} (${(file.size / 1024).toFixed(1)} KB)`
        : 'No file selected.';
});

document.querySelectorAll('[data-toggle-password]').forEach(button => {
    button.addEventListener('click', () => {
        const input = document.getElementById(button.dataset.togglePassword);
        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        button.textContent = show ? 'Hide' : 'Show';
        button.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        button.setAttribute('aria-pressed', String(show));
    });
});

document.querySelectorAll('[data-confirm-delete]').forEach(form => {
    form.addEventListener('submit', event => {
        const message = form.dataset.confirmMessage || 'Delete this evidence? This cannot be undone.';
        if (!window.confirm(message)) {
            event.preventDefault();
        }
    });
});

document.querySelector('[data-file-search], [data-table-search]')?.addEventListener('input', event => {
    const query = event.target.value.trim().toLowerCase();
    const rows = document.querySelectorAll('[data-file-row], [data-filter-row]');
    let matches = 0;

    rows.forEach(row => {
        const name = (row.dataset.search || row.querySelector('td a').textContent).toLowerCase();
        row.hidden = !name.includes(query);
        if (!row.hidden) matches++;
    });

    document.querySelector('[data-no-results]').hidden = rows.length === 0 || matches > 0;
});
