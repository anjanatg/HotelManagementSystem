document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'item_id') {
        const itemSelect = e.target;
        const unitInput = document.getElementById('unit');
        const minStockInput = document.getElementById('minimum_stock_level');
        const stockInfo = document.getElementById('existingStockInfo');

        const selectedOption = itemSelect.options[itemSelect.selectedIndex];
        const unit = selectedOption.getAttribute('data-unit') || '';
        unitInput.value = unit;

        const itemId = itemSelect.value;
        if (!itemId) {
            stockInfo.style.display = 'none';
            minStockInput.value = '';
            return;
        }

        fetch(window.itemInfoRouteBase + '/' + itemId)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    stockInfo.textContent = 'This item already has ' + data.current_quantity + ' ' + unit + ' in stock. Entered quantity will be added to it.';
                    stockInfo.style.display = 'block';
                    minStockInput.value = data.minimum_stock_level;
                } else {
                    stockInfo.style.display = 'none';
                    minStockInput.value = '';
                }
            })
            .catch(err => console.error(err));
    }
});
// search and filter
function applyInventoryFilters() {
    const searchInput = document.getElementById('itemSearch');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('#inventoryTable tbody tr');

    if (!rows.length) return;

    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
    const selectedStatus = statusFilter ? statusFilter.value : 'all';

    let visibleCount = 0;

    rows.forEach(function (row) {
        const rowName = row.getAttribute('data-name') || '';
        const rowStatus = row.getAttribute('data-status');

        const matchesSearch = rowName.includes(searchTerm);
        const matchesStatus = selectedStatus === 'all' || rowStatus === selectedStatus;

        if (matchesSearch && matchesStatus) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const noResultsMsg = document.getElementById('noResultsMsg');
    if (noResultsMsg) {
        noResultsMsg.style.display = visibleCount === 0 ? 'block' : 'none';
    }
}

document.addEventListener('input', function (e) {
    if (e.target && e.target.id === 'itemSearch') {
        applyInventoryFilters();
    }
});

document.addEventListener('change', function (e) {
    if (e.target && e.target.id === 'statusFilter') {
        applyInventoryFilters();
    }
});