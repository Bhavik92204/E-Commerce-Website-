document.addEventListener('DOMContentLoaded', function() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    function updateCart() {
        cartItems.innerHTML = '';
        let total = 0;
        cart.forEach(item => {
            const itemElement = document.createElement('div');
            itemElement.className = 'cart-item';
            itemElement.innerHTML = `
                <h3>${item.name}</h3>
                <p>Price: $${item.price}</p>
                <button class="remove-from-cart" data-id="${item.id}">Remove</button>
            `;
            cartItems.appendChild(itemElement);
            total += parseFloat(item.price);
        });
        cartTotal.innerText = 'Total: $' + total.toFixed(2);

        document.querySelectorAll('.remove-from-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                cart = cart.filter(item => item.id !== productId);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCart();
            });
        });
    }

    updateCart();
});
