document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('userForm');
    const nameInput = document.getElementById('name');
    const nameError = document.getElementById('nameError');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (window.nameExists) {
            nameError.style.display = 'inline';
            nameInput.classList.add('is-invalid');
            nameInput.focus();
            return;
        }

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;

        // Loading state ON
        submitBtn.disabled = true;
        submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Saving...`;

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async response => {
            const data = await response.json();

            if (!response.ok) {
                if (data.errors && data.errors.name) {
                    nameError.textContent = data.errors.name[0];
                    nameError.style.display = 'inline';
                    nameInput.classList.add('is-invalid');
                } else {
                    alert(data.message || 'Something went wrong. Please try again.');
                }
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                return;
            }

            if (data.success) {
                window.location.href = window.usersListRoute;
                return; // page navigate cheyyum, button reset venda
            }

            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Something went wrong. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
});