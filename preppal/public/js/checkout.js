/*
  Student & ID: (Agraj Khanna 240195519 ID / Gurpreet Singh Sidhu 230237915 ID)
  Description: Checkout Implementation (Laravel backend version)
*/

document.addEventListener("DOMContentLoaded", function () {

    const CART_KEY = 'preppalCart';

    function loadCart() {
        try {
            return JSON.parse(localStorage.getItem(CART_KEY)) || [];
        } catch {
            return [];
        }
    }

    const itemsEl = document.getElementById('checkoutItems');
    const totalEl = document.getElementById('checkoutTotal');
    const emptyMsg = document.getElementById('checkoutEmptyMessage');
    const form = document.getElementById('checkoutForm');

    if (!itemsEl || !totalEl || !form) return;

    const cartItems = loadCart();


    // RENDER CART TO PAGE
    function renderCart() {

        itemsEl.innerHTML = '';

        if (!cartItems.length) {
            emptyMsg.style.display = 'block';
            form.style.display = 'none';
            totalEl.textContent = "Total: £0.00";
            return;
        }

        emptyMsg.style.display = 'none';
        form.style.display = 'block';

        let total = 0;

        cartItems.forEach(item => {

            const li = document.createElement('li');
            li.className = 'checkout-item-row';

            // Thumbnail
            const thumb = document.createElement('div');
            thumb.className = 'checkout-thumb';

            const img = document.createElement('img');
            img.src = item.image || '';
            img.alt = item.name;
            thumb.appendChild(img);

            // Item name + qty
            const name = document.createElement('span');
            name.className = 'checkout-item-name';
            name.textContent = `${item.name} × ${item.qty}`;

            // Price
            const price = document.createElement('span');
            price.className = 'checkout-item-price';
            const lineTotal = (item.price || 0) * (item.qty || 0);
            price.textContent = `£${lineTotal.toFixed(2)}`;

            total += lineTotal;

            li.appendChild(thumb);
            li.appendChild(name);
            li.appendChild(price);

            itemsEl.appendChild(li);

        });

        totalEl.textContent = `Total: £${total.toFixed(2)}`;
    }

    renderCart();

    // SUBMIT ORDER TO LARAVEL
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        if (!cartItems.length) {
            alert("Your cart is empty.");
            return;
        }

        const payload = {
            name: document.getElementById('coName').value,
            email: document.getElementById('coEmail').value,
            address: document.getElementById('coAddress').value,
            city: document.getElementById('coCity').value,
            postcode: document.getElementById('coPostcode').value,
            notes: document.getElementById('coNotes').value,
            items: cartItems
        };

        const response = await fetch('/checkout', {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();

        if (data.success) {
            localStorage.removeItem('preppalCart');
            alert("Order placed successfully!");
            window.location.href = "/orders";
        } else {
            alert("Something went wrong placing your order.");
        }
    });

});
