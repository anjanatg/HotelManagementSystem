document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('nameError');
    const form = document.getElementById('userForm');
    let nameExists = false;

    if (!nameInput || !form) return;

    nameInput.addEventListener('blur', function () {
        const name = nameInput.value.trim();

        if (!name) {
            nameError.style.display = 'none';
            nameInput.classList.remove('is-invalid');
            nameExists = false;
            return;
        }

        fetch(window.checkNameRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ name: name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                nameError.style.display = 'inline';
                nameInput.classList.add('is-invalid');
                nameExists = true;
            } else {
                nameError.style.display = 'none';
                nameInput.classList.remove('is-invalid');
                nameExists = false;
            }
        });
    });

    form.addEventListener('submit', function (e) {
        if (nameExists) {
            e.preventDefault(); 
        }
    });
});