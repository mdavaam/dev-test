<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Product Management</title>
    <link rel="stylesheet" href="{{ asset('css/products.css') }}">
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar">
        <div class="nav-container">
                <span class="nav-title">Products</span>
            </div>
        </div>
    </nav>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success" id="alert">
        <span>{{ session('success') }}</span>
        <button onclick="closeAlert()" class="alert-close">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error" id="alert">
        <span>{{ session('error') }}</span>
        <button onclick="closeAlert()" class="alert-close">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @endif

    <div class="container">
        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <h1 class="page-title">Products</h1>
                <p class="page-subtitle">Manage your product inventory</p>
            </div>
            <button onclick="openEditModal('create')" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Product
            </button>
        </div>

        {{-- Card Container --}}
        <div class="card">
            {{-- Search --}}
            <div class="search-container">
                <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input
                    type="text"
                    id="searchInput"
                    placeholder="Search products..."
                    class="search-input"
                    onkeyup="filterProducts()"
                >
            </div>

            {{-- Table --}}
            <div class="table-container">
                @if(count($products) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Qty</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @foreach($products as $product)
                        <tr class="product-row"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-amount="{{ $product->amount }}"
                            data-qty="{{ $product->qty }}"
                            data-search="{{ strtolower($product->name) }}">
                            <td class="font-medium">{{ $product->name }}</td>
                            <td>{{ 'Rp ' . number_format($product->amount, 0, ',', '.') }}</td>
                            <td>{{ $product->qty }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button type="button" onclick="openEditModal('edit', {{ $product->id }})" class="btn-icon btn-icon-edit" title="Edit">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button type="button" onclick="openDeleteModal({{ $product->id }})" class="btn-icon btn-icon-delete" title="Delete">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="noResults" class="empty-state" style="display: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3>No products found</h3>
                    <p>Try a different search term</p>
                </div>
                @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3>No products found</h3>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create/Edit Modal --}}
    <div id="productModal" class="modal">
        <div class="modal-overlay" onclick="closeModal()"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Add Product</h2>
                <button onclick="closeModal()" class="btn-icon">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="productForm" action="{{ route('products.store') }}" method="POST" onsubmit="return handleSubmit(event)">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <input type="hidden" name="id" id="productId">

                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Enter product name"
                        class="form-input @error('name') input-error @enderror"
                        value="{{ old('name') }}"
                        required
                    >
                    <span class="error-message" id="nameError"></span>
                </div>

                <div class="form-group">
                    <label for="amount">Amount (IDR)</label>
                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        placeholder="0"
                        min="0"
                        class="form-input @error('amount') input-error @enderror"
                        value="{{ old('amount') }}"
                        required
                    >
                    <span class="error-message" id="amountError"></span>
                </div>

                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input
                        type="number"
                        id="qty"
                        name="qty"
                        placeholder="0"
                        min="0"
                        class="form-input @error('qty') input-error @enderror"
                        value="{{ old('qty') }}"
                        required
                    >
                    <span class="error-message" id="qtyError"></span>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="modal">
        <div class="modal-overlay" onclick="closeDeleteModal()"></div>
        <div class="modal-content modal-sm">
            <div class="modal-header">
                <h2>Delete Product</h2>
            </div>
            <p class="modal-text">Are you sure you want to delete this product? This action cannot be undone.</p>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" onclick="closeDeleteModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/products.js') }}"></script>
</body>
</html>
