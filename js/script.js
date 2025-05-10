console.log("Script loaded");

const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    })
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    })
}

document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('toggle-btn')) {
        const button = e.target;
        const target = document.querySelector(button.dataset.target);
        if (target) {
            target.classList.toggle('expanded');
            button.textContent = target.classList.contains('expanded') ? 'Show Less' : 'Show More';
        }
    }
});

// CART SIDEBAR
document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.querySelector('#cart-icon');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');
    const cartClose = document.getElementById('cart-close');

    console.log("DOM fully loaded");
    fetchCartData();
    console.log("cartIcon is", cartIcon);
    if (!cartIcon) return;

    function toggleCart(open) {
        if (open) {
            cartSidebar.classList.add('open');
            cartOverlay.classList.add('active');
            fetchCartData();
        } else {
            cartSidebar.classList.remove('open');
            cartOverlay.classList.remove('active');
        }
    }

    cartIcon.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation(); // stop any parent listeners
        console.log("Cart icon clicked");
        toggleCart(true);
    });

    cartClose.addEventListener('click', function () {
        toggleCart(false);
    });

    cartOverlay.addEventListener('click', function () {
        toggleCart(false);
    });

    function fetchCartData() {
        fetch(ajaxCartUrl)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.text();
            })
            .then(txt => {
                console.log("Cart response:", txt);
                try {
                    const data = JSON.parse(txt);

                    const content = document.getElementById('cart-content');
                    const subtotal = document.getElementById('cart-subtotal');
                    let html = '';

                    if (data.items.length === 0) {
                        html = '<p>Your cart is empty.</p>';
                    } else {
                        data.items.forEach(item => {
                            html += `
                                <div class="cart-item">
                                    <img src="${baseUrl}/images/products/${item.image}" class="cart-thumb" />
                                    <div class="cart-item-details">
                                    <p class="cart-product-name">${item.name}</p>
                                    <div class="cart-price-row">
                                        <span class="cart-product-price">₱${item.price.toFixed(2)}</span>
                                        <div class="cart-qty-controls">
                                        <button class="qty-btn" data-action="decrease" data-id="${item.id}">–</button>
                                        <span class="cart-qty">${item.quantity}</span>
                                        <button class="qty-btn" data-action="increase" data-id="${item.id}">+</button>
                                        </div>
                                    </div>
                                    <a href="#" class="remove-item" data-id="${item.id}">Remove</a>
                                    </div>
                                </div>`;
                        });
                    }

                    content.innerHTML = html;
                    subtotal.textContent = `₱${data.subtotal.toFixed(2)}`;
                    updateCartCount(data.totalQuantity);
                } catch (err) {
                    console.error("JSON parse error", err);
                }
            })
            .catch(err => {
                console.error("Fetch error:", err);
            });
    }


    function updateCartCount(count) {
        let badge = cartIcon.querySelector('.cart-count');
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'cart-count';
            cartIcon.style.position = 'relative';
            cartIcon.appendChild(badge);

        }
        if (count === 0) {
            if (badge) badge.remove();
        } else {
            badge.textContent = count;
        }

    }
});
