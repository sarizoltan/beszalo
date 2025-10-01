// Kosár kezelő JavaScript
const Cart = {
    // AJAX útvonal beállítása - FONTOS: relatív útvonal használata
    ajaxUrl: window.location.origin + '/sp_store/ajax/cart_handler.php',
    siteUrl: window.location.origin + '/sp_store',

    init: function() {
        console.log('Cart initialized'); // Debug
        this.bindEvents();
    },

    bindEvents: function() {
        // Kosár dropdown megnyitásakor töltsük be a termékeket
        const cartBtn = document.getElementById('cartDropdownBtn');
        if (cartBtn) {
            cartBtn.addEventListener('click', (e) => {
                console.log('Cart button clicked'); // Debug
                this.loadCartItems();
            });
        }

        // Kosárba helyezés gombok
        document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = btn.dataset.productId;
                const quantity = btn.dataset.quantity || 1;
                console.log('Add to cart:', productId, quantity); // Debug
                this.addToCart(productId, quantity);
            });
        });
    },

    loadCartItems: function() {
        const container = document.getElementById('cartItemsContainer');
        if (!container) {
            console.error('Cart container not found!');
            return;
        }

        container.innerHTML = '<div class="cart-loading"><div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Töltés...</span></div></div>';

        console.log('Fetching cart from:', this.ajaxUrl + '?action=get'); // Debug

        fetch(this.ajaxUrl + '?action=get', {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                console.log('Response status:', response.status); // Debug
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Cart data received:', data); // Debug
                if (data.success) {
                    this.renderCartItems(data.items);
                    this.updateCartCount(data.cart_count);
                    this.updateCartTotal(data.cart_total);
                } else {
                    this.showError(data.message);
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                container.innerHTML = '<div class="cart-empty"><p class="text-danger">Hiba történt a kosár betöltése során</p></div>';
            });
    },

    renderCartItems: function(items) {
        const container = document.getElementById('cartItemsContainer');
        
        if (items.length === 0) {
            container.innerHTML = `
                <div class="cart-empty">
                    <i class="bi bi-cart-x"></i>
                    <p>A kosár üres</p>
                </div>
            `;
            return;
        }

        let html = '';
        items.forEach(item => {
            // Kép útvonal javítása
            let imagePath = item.image_path || 'assets/images/no-image.png';
            
            // Ha már fix_image_path feldolgozta PHP oldalon, akkor nincs public/ prefix
            // Ha mégis van, távolítsuk el
            if (imagePath.startsWith('public/')) {
                imagePath = imagePath.substring(7);
            }
            
            // Teljes URL összeállítása
            const imageUrl = this.siteUrl + '/' + imagePath;
            const productUrl = this.siteUrl + '/termek/' + item.slug;
            const categoryUrl = this.siteUrl + '/kategoria/' + item.category_slug;

            console.log('Image URL:', imageUrl); // Debug

            html += `
                <div class="cart-item" data-product-id="${item.product_id}">
                    <img src="${imageUrl}" 
                         alt="${this.escapeHtml(item.name)}" 
                         class="cart-item-image" 
                         onerror="this.onerror=null; this.src='${this.siteUrl}/assets/images/no-image.png';">
                    <div class="cart-item-details">
                        <a href="${productUrl}" class="cart-item-title">${this.escapeHtml(item.name)}</a>
                        <a href="${categoryUrl}" class="cart-item-category">
                            <i class="bi bi-tag"></i> ${this.escapeHtml(item.category_name)}
                        </a>
                        <div class="cart-item-price">${this.formatPrice(item.current_price)} Ft</div>
                        <div class="cart-item-quantity">
                            <button class="btn btn-sm btn-outline-secondary quantity-decrease" data-product-id="${item.product_id}">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" class="quantity-input" value="${item.quantity}" min="1" data-product-id="${item.product_id}">
                            <button class="btn btn-sm btn-outline-secondary quantity-increase" data-product-id="${item.product_id}">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="cart-item-remove" data-product-id="${item.product_id}" title="Eltávolítás">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            `;
        });

        container.innerHTML = html;
        this.bindCartItemEvents();
    },

    bindCartItemEvents: function() {
        // Mennyiség növelése
        document.querySelectorAll('.quantity-increase').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = btn.dataset.productId;
                const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                const newQuantity = parseInt(input.value) + 1;
                this.updateQuantity(productId, newQuantity);
            });
        });

        // Mennyiség csökkentése
        document.querySelectorAll('.quantity-decrease').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = btn.dataset.productId;
                const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
                const newQuantity = Math.max(1, parseInt(input.value) - 1);
                this.updateQuantity(productId, newQuantity);
            });
        });

        // Mennyiség kézi változtatása
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('change', (e) => {
                const productId = input.dataset.productId;
                const newQuantity = Math.max(1, parseInt(input.value) || 1);
                input.value = newQuantity; // Biztosítjuk, hogy érvényes érték legyen
                this.updateQuantity(productId, newQuantity);
            });
        });

        // Termék eltávolítása
        document.querySelectorAll('.cart-item-remove').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const productId = btn.dataset.productId;
                this.removeFromCart(productId);
            });
        });
    },

    addToCart: function(productId, quantity = 1) {
        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch(this.ajaxUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Add to cart response:', data); // Debug
            if (data.success) {
                this.updateCartCount(data.cart_count);
                this.updateCartTotal(data.cart_total);
                this.showSuccess(data.message);
                // Automatikusan megnyitjuk a kosarat
                const dropdown = new bootstrap.Dropdown(document.getElementById('cartDropdownBtn'));
                dropdown.show();
                this.loadCartItems();
            } else {
                this.showError(data.message);
            }
        })
        .catch(error => {
            console.error('Add to cart error:', error);
            this.showError('Hiba történt a termék hozzáadása során');
        });
    },

    updateQuantity: function(productId, quantity) {
        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch(this.ajaxUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateCartCount(data.cart_count);
                this.updateCartTotal(data.cart_total);
                this.loadCartItems();
            } else {
                this.showError(data.message);
            }
        })
        .catch(error => {
            console.error('Update quantity error:', error);
            this.showError('Hiba történt a mennyiség frissítése során');
        });
    },

    removeFromCart: function(productId) {
        if (!confirm('Biztosan eltávolítod ezt a terméket a kosárból?')) {
            return;
        }

        const formData = new FormData();
        formData.append('action', 'remove');
        formData.append('product_id', productId);

        fetch(this.ajaxUrl, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateCartCount(data.cart_count);
                this.updateCartTotal(data.cart_total);
                this.showSuccess(data.message);
                this.loadCartItems();
            } else {
                this.showError(data.message);
            }
        })
        .catch(error => {
            console.error('Remove from cart error:', error);
            this.showError('Hiba történt a termék eltávolítása során');
        });
    },

    updateCartCount: function(count) {
        const badge = document.getElementById('cartCountBadge');
        const itemCount = document.getElementById('cartItemCount');
        
        if (badge) badge.textContent = count;
        if (itemCount) itemCount.textContent = count;
    },

    updateCartTotal: function(total) {
        const totalElement = document.getElementById('cartTotalAmount');
        if (totalElement) {
            totalElement.textContent = this.formatPrice(total) + ' Ft';
        }
    },

    formatPrice: function(price) {
        return new Intl.NumberFormat('hu-HU', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(price);
    },

    escapeHtml: function(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return String(text).replace(/[&<>"']/g, m => map[m]);
    },

    showSuccess: function(message) {
        // Bootstrap toast implementáció később
        console.log('Success:', message);
        alert(message);
    },

    showError: function(message) {
        console.error('Error:', message);
        alert('Hiba: ' + message);
    }
};

// Inicializálás amikor a DOM betöltődött
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing cart...');
    Cart.init();
});