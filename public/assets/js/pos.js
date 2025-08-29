const POS = {
    cart: [],
    isScanning: false,
    
    init() {
        this.setupEventListeners();
        this.updateTime();
        this.updateCartUI();
        this.updateSummary();
        
        // Update time every second
        setInterval(() => this.updateTime(), 1000);
    },
    
    setupEventListeners() {
        // Scan button
        document.getElementById('scan-btn').addEventListener('click', () => this.handleScan());
        
        // Manual search button
        document.getElementById('search-btn').addEventListener('click', () => this.handleManualAdd());
        
        // Manual input enter key
        document.getElementById('manual-code').addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.handleManualAdd();
            }
        });
        
        // Payment method buttons
        document.querySelectorAll('.payment-method-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const method = e.currentTarget.getAttribute('data-method');
                this.handlePayment(method);
            });
        });
    },
    
    updateTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('id-ID');
        document.getElementById('current-time').textContent = timeString;
    },
    
    handleScan() {
        if (this.isScanning) return;
        
        this.isScanning = true;
        const scanBtn = document.getElementById('scan-btn');
        const scanText = document.getElementById('scan-text');
        
        // Update button state
        scanBtn.disabled = true;
        scanText.innerHTML = '<span class="spinner"></span> Scanning...';
        
        // Simulate scanning process
        setTimeout(() => {
            this.isScanning = false;
            scanBtn.disabled = false;
            scanText.innerHTML = '<i data-lucide="scan"></i> Scan Barcode';
            
            // Re-initialize icons
            lucide.createIcons();
            
            // Mock product data
            const mockProduct = {
                id: Date.now(),
                code: '1234567890',
                name: 'Produk Scanned',
                price: 25000,
                quantity: 1
            };
            
            this.addToCart(mockProduct);
            this.showToast('Produk ditambahkan', `${mockProduct.name} berhasil ditambahkan ke keranjang`);
        }, 2000);
    },
    
    handleManualAdd() {
        const codeInput = document.getElementById('manual-code');
        const code = codeInput.value.trim();
        
        if (code) {
            // Mock product lookup by code
            const mockProduct = {
                id: Date.now(),
                code: code,
                name: `Produk ${code}`,
                price: Math.floor(Math.random() * 50000) + 10000,
                quantity: 1
            };
            
            this.addToCart(mockProduct);
            this.showToast('Produk ditambahkan', `${mockProduct.name} berhasil ditambahkan ke keranjang`);
            codeInput.value = '';
        }
    },
    
    addToCart(product) {
        const existingItem = this.cart.find(item => item.code === product.code);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cart.push(product);
        }
        
        this.updateCartUI();
        this.updateSummary();
    },
    
    updateQuantity(id, quantity) {
        const item = this.cart.find(item => item.id === id);
        if (item) {
            item.quantity = Math.max(1, quantity);
            this.updateCartUI();
            this.updateSummary();
        }
    },
    
    removeItem(id) {
        this.cart = this.cart.filter(item => item.id !== id);
        this.updateCartUI();
        this.updateSummary();
    },
    
    updateCartUI() {
        const cartContainer = document.getElementById('cart-items');
        const emptyCart = document.getElementById('empty-cart');
        const cartBadge = document.getElementById('cart-badge');
        
        // Update badge
        cartBadge.textContent = `${this.cart.length} item${this.cart.length !== 1 ? 's' : ''}`;
        
        if (this.cart.length === 0) {
            emptyCart.style.display = 'block';
            // Clear any existing cart items
            const existingItems = cartContainer.querySelectorAll('.cart-item');
            existingItems.forEach(item => item.remove());
        } else {
            emptyCart.style.display = 'none';
            
            // Clear and rebuild cart items
            const existingItems = cartContainer.querySelectorAll('.cart-item');
            existingItems.forEach(item => item.remove());
            
            this.cart.forEach(item => {
                const cartItemElement = this.createCartItemElement(item);
                cartContainer.appendChild(cartItemElement);
            });
        }
    },
    
    createCartItemElement(item) {
        const div = document.createElement('div');
        div.className = 'cart-item';
        div.innerHTML = `
            <div class="cart-item-info">
                <div class="cart-item-name">${item.name}</div>
                <div class="cart-item-code">Kode: ${item.code}</div>
                <div class="cart-item-price">${this.formatCurrency(item.price)}</div>
            </div>
            
            <div class="quantity-controls">
                <button class="quantity-btn" onclick="POS.updateQuantity(${item.id}, ${item.quantity - 1})">
                    <i data-lucide="minus"></i>
                </button>
                <span class="quantity-display">${item.quantity}</span>
                <button class="quantity-btn" onclick="POS.updateQuantity(${item.id}, ${item.quantity + 1})">
                    <i data-lucide="plus"></i>
                </button>
            </div>
            
            <button class="remove-btn" onclick="POS.removeItem(${item.id})">
                <i data-lucide="trash-2"></i>
            </button>
            
            <div class="cart-item-total">
                <div class="cart-total-price">${this.formatCurrency(item.price * item.quantity)}</div>
            </div>
        `;
        
        // Re-initialize icons for this element
        setTimeout(() => lucide.createIcons(), 0);
        
        return div;
    },
    
    updateSummary() {
        const subtotal = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        const tax = subtotal * 0.1;
        const total = subtotal + tax;
        
        document.getElementById('subtotal').textContent = this.formatCurrency(subtotal);
        document.getElementById('tax').textContent = this.formatCurrency(tax);
        document.getElementById('total').textContent = this.formatCurrency(total);
    },
    
    handlePayment(method) {
        if (this.cart.length === 0) {
            this.showToast('Keranjang Kosong', 'Tidak ada item dalam keranjang untuk dibayar', 'warning');
            return;
        }
        
        const methodNames = {
            'cash': 'tunai',
            'card': 'kartu',
            'ewallet': 'e-wallet'
        };
        
        this.showToast(
            'Pembayaran berhasil',
            `Transaksi dengan ${methodNames[method]} berhasil diproses`,
            'success'
        );
        
        // Clear cart
        this.cart = [];
        this.updateCartUI();
        this.updateSummary();
        
        // Here you would typically send the transaction data to your Laravel backend
        // this.sendTransactionToServer(transactionData);
    },
    
    // Method to send transaction data to Laravel backend
    async sendTransactionToServer(transactionData) {
        try {
            const response = await fetch('/api/transactions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(transactionData)
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const result = await response.json();
            console.log('Transaction saved:', result);
        } catch (error) {
            console.error('Error saving transaction:', error);
            this.showToast('Error', 'Gagal menyimpan transaksi', 'error');
        }
    },
    
    formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(amount);
    },
    
    showToast(title, description, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.innerHTML = `
            <div class="toast-title">${title}</div>
            <div class="toast-description">${description}</div>
        `;
        
        toastContainer.appendChild(toast);
        
        // Trigger animation
        setTimeout(() => toast.classList.add('show'), 10);
        
        // Remove toast after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toastContainer.removeChild(toast), 300);
        }, 3000);
    }
};