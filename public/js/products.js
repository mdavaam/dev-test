function closeAlert() {
    const alert = document.getElementById('alert');
    if (alert) {
        alert.style.animation = 'slideOut 0.3s ease-out';
        setTimeout(() => alert.remove(), 300);
    }
}

if (document.getElementById('alert')) {
    setTimeout(() => {
        closeAlert();
    }, 3000);
}

function filterProducts() {
    const searchInput = document.getElementById('searchInput');
    const searchQuery = searchInput.value.toLowerCase();
    const rows = document.querySelectorAll('.product-row');
    const noResults = document.getElementById('noResults');
    const table = document.querySelector('.table');
    let visibleCount = 0;

    rows.forEach(row => {
        const productName = row.getAttribute('data-search').toLowerCase();
        if (productName.includes(searchQuery)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    if (noResults) {
        if (visibleCount === 0) {
            noResults.style.display = 'block';
            if (table) table.style.display = 'none';
        } else {
            noResults.style.display = 'none';
            if (table) table.style.display = 'table';
        }
    }
}

function openEditModal(mode, productId = null) {
    console.log('openEditModal called with:', mode, productId);

    const modal = document.getElementById('productModal');
    const form = document.getElementById('productForm');
    const modalTitle = document.getElementById('modalTitle');
    const formMethod = document.getElementById('formMethod');

    if (!modal) {
        console.error('Modal not found!');
        return;
    }

    clearErrors();

    if (mode === 'create') {
        console.log('Opening CREATE modal');
        modalTitle.textContent = 'Add Product';
        form.action = '/products';
        formMethod.value = 'POST';
        form.reset();
        document.getElementById('productId').value = '';
    } else if (mode === 'edit' && productId) {
        console.log('Opening EDIT modal for product:', productId);

        const row = document.querySelector(`tr[data-id="${productId}"]`);
        console.log('Found row:', row);

        if (row) {
            const productName = row.getAttribute('data-name');
            const productAmount = row.getAttribute('data-amount');
            const productQty = row.getAttribute('data-qty');

            console.log('Product data:', {
                id: productId,
                name: productName,
                amount: productAmount,
                qty: productQty
            });

            modalTitle.textContent = 'Edit Product';
            form.action = `/products/${productId}`;
            formMethod.value = 'PUT';
            document.getElementById('productId').value = productId;
            document.getElementById('name').value = productName;
            document.getElementById('amount').value = productAmount;
            document.getElementById('qty').value = productQty;
        } else {
            console.error('Product row not found for ID:', productId);
            alert('Error: Product data not found!');
            return;
        }
    }

    console.log('Adding active class to modal');
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
    console.log('Modal should be visible now');
}

function handleSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const method = document.getElementById('formMethod').value;

    console.log('Form Action:', form.action);
    console.log('Form Method:', method);
    console.log('Form Data:', {
        name: formData.get('name'),
        amount: formData.get('amount'),
        qty: formData.get('qty')
    });

    form.submit();

    return false;
}

function closeModal() {
    const modal = document.getElementById('productModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    clearErrors();
}

function openDeleteModal(productId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/products/${productId}`;
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

function clearErrors() {
    const errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(msg => msg.textContent = '');

    const inputs = document.querySelectorAll('.input-error');
    inputs.forEach(input => input.classList.remove('input-error'));
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const productModal = document.getElementById('productModal');
        const deleteModal = document.getElementById('deleteModal');

        if (productModal && productModal.classList.contains('active')) {
            closeModal();
        }
        if (deleteModal && deleteModal.classList.contains('active')) {
            closeDeleteModal();
        }
    }
});


const style = document.createElement('style');
style.textContent = `
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
