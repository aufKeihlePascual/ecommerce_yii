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
        const url = '/cart/ajaxCart'; // Make sure this returns JSON
        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error('Network error');
                return res.text(); // Use .text() for debugging
            })
            .then(txt => {
                console.log("Cart response:", txt);
                // Try parsing manually
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
                                    <img src="/images/products/${item.image}" class="cart-thumb" />
                                    <div>
                                    <p><strong>${item.name}</strong></p>
                                    <p>₱${item.price} × ${item.quantity}</p>
                                    </div>
                                    <hr>
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
            badge.style.position = 'absolute';
            badge.style.top = '-5px';
            badge.style.right = '-8px';
            badge.style.background = '#246083';
            badge.style.color = '#fff';
            badge.style.fontSize = '12px';
            badge.style.borderRadius = '50%';
            badge.style.padding = '3px 6px';
            cartIcon.style.position = 'relative';
            cartIcon.appendChild(badge);
        }
        badge.textContent = count;
    }
});
