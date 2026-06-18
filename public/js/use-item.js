document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('useItemForm');
    const alertBox = document.getElementById('alertBox');
    const qtyError = document.getElementById('qtyError');
    const inventorySelect = document.getElementById('inventory_id');
    const quantityInput = document.getElementById('used_quantity');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        qtyError.style.display = 'none';
        alertBox.style.display = 'none';

        const inventoryId = inventorySelect.value;
        const usedQuantity = quantityInput.value;

        if (!inventoryId) {
            qtyError.textContent = 'Please select an item.';
            qtyError.style.display = 'inline';
            return;
        }

        if (!usedQuantity || usedQuantity <= 0) {
            qtyError.textContent = 'Please enter a valid quantity.';
            qtyError.style.display = 'inline';
            return;
        }

        fetch(window.useItemRoute, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                inventory_id: inventoryId,
                used_quantity: usedQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alertBox.className = 'alert alert-success';
                alertBox.textContent = data.message;
                alertBox.style.display = 'block';

                const selectedOption = inventorySelect.options[inventorySelect.selectedIndex];
                quantityInput.value = '';

                location.reload(); 
            } else {
                alertBox.className = 'alert alert-danger';
                alertBox.textContent = data.message;
                alertBox.style.display = 'block';
            }
        })
        .catch(() => {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = 'Something went wrong. Please try again.';
            alertBox.style.display = 'block';
        });
    });
});