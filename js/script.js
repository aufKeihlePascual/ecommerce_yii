console.log("Script loaded");

const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active');
    });
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active');
    });
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
    attachPageCartEventListeners();
    
    const cartIcon = document.querySelector('#cart-icon');
    const cartSidebar = document.getElementById('cart-sidebar');
    const cartOverlay = document.getElementById('cart-overlay');
    const cartClose = document.getElementById('cart-close');

    console.log("DOM fully loaded");

    fetchCartData();

    document.addEventListener('click', function (e) {
        const link = e.target.closest('.add-to-cart-link');
        if (link) {
            e.preventDefault();

            const productId = link.dataset.id;

            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    try {
                        const response = JSON.parse(this.responseText);
                        if (response.success) {
                            showCartToast("Added to cart");
                            if (typeof fetchCartData === "function") {
                                fetchCartData();
                            }
                        } else {
                            alert("Failed: " + response.message);
                        }
                    } catch (e) {
                        console.error("Invalid JSON from server", e);
                    }
                }
            };

            xhttp.open("POST", baseUrl + "/index.php/cart/addToCart/" + productId, true);
            xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhttp.send();
        }
    });

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
        e.stopPropagation();
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
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    try {
                        var data = JSON.parse(this.responseText);

                        var content = document.getElementById('cart-content');
                        var subtotal = document.getElementById('cart-subtotal');
                        var html = '';

                        if (data.items.length === 0) {
                            html = '<p>You currently have no items in the cart.</p>';
                        } else {
                            data.items.forEach(function (item) {
                                html += `
                                    <div class="cart-item">
                                        <div class="cart-thumb">
                                            <img src="${baseUrl}/images/products/${item.image}" alt="${item.name}" />
                                        </div>
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
                        attachCartEventListeners();
                    } catch (err) {
                        console.error("JSON parse error", err);
                    }
                } else {
                    console.error("Fetch error: Status", this.status);
                }
            }
        };
        xhttp.open("GET", ajaxCartUrl, true);
        xhttp.send();
    }

    function updateCartCount(count) {
        var badge = cartIcon.querySelector('.cart-count');
        if (count === 0) {
            if (badge) badge.remove();
        } else {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'cart-count';
                cartIcon.style.position = 'relative';
                cartIcon.appendChild(badge);
            }
            badge.textContent = count;
        }
    }

    function attachCartEventListeners() {
        const qtyButtons = document.querySelectorAll('#cart-sidebar .qty-btn'); // scoped to sidebar
        qtyButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const action = this.dataset.action;
                const productId = this.dataset.id;

                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        try {
                            const data = JSON.parse(this.responseText);
                            if (data.success) {
                                fetchCartData();
                                reloadShoppingCartTable();
                            }
                        } catch (err) {
                            console.error("JSON parse error", err);
                        }
                    }
                };
                xhttp.open("POST", baseUrl + "/index.php/cart/updateQuantity", true);
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify({ productId: productId, action: action }));
            });
        });

        // Sidebar remove buttons
        const removeButtons = document.querySelectorAll('#cart-sidebar .remove-item');
        removeButtons.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const productId = this.dataset.id;

                const xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        try {
                            const data = JSON.parse(this.responseText);
                            if (data.success) {
                                fetchCartData();
                                reloadShoppingCartTable();
                            }
                        } catch (err) {
                            console.error("JSON parse error", err);
                        }
                    }
                };
                xhttp.open("POST", baseUrl + "/index.php/cart/removeItem", true);
                xhttp.setRequestHeader("Content-Type", "application/json");
                xhttp.send(JSON.stringify({ productId: productId }));
            });
        });
    }


    function showCartToast(message = "Added to cart") {
        const toast = document.getElementById("cart-toast");
        const msg = document.getElementById("cart-toast-message");

        msg.textContent = message;
        toast.classList.remove("hidden");
        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
            setTimeout(() => {
                toast.classList.add("hidden");
            }, 400);
        }, 2000);
    }

});

function attachPageCartEventListeners() {
    const pageCart = document.getElementById('shopping-cart');
    if (!pageCart) return;

    const buttons = pageCart.querySelectorAll('.page-cart-btn');
    buttons.forEach((btn) => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.id;
            const action = this.dataset.action;

            const xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    try {
                        const res = JSON.parse(this.responseText);
                        if (res.success) {
                            location.reload(); // or refresh cart section only
                        }
                    } catch (e) {
                        console.error("Error parsing updateQuantity response", e);
                    }
                }
            };
            xhttp.open("POST", baseUrl + "/index.php/cart/updateQuantity", true);
            xhttp.setRequestHeader("Content-Type", "application/json");
            xhttp.send(JSON.stringify({ productId: productId, action: action }));
        });
    });
}

function reloadShoppingCartTable() {
    const container = document.getElementById('shopping-cart-table');
    if (!container) return;

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            try {
                const response = JSON.parse(this.responseText);
                if (response.success && response.html) {
                    container.innerHTML = response.html;
                    attachPageCartEventListeners();
                }
            } catch (e) {
                console.error("Failed to update cart table:", e);
            }
        }
    };

    xhttp.open("GET", baseUrl + "/index.php/cart/refreshCartTable", true);
    xhttp.send();
}
