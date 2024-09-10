document.addEventListener('DOMContentLoaded', function() {
    const cartCount = document.getElementById('cart-count');
    let cart = [];

    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productItem = this.parentElement;
            const productId = productItem.getAttribute('data-id');
            const productName = productItem.getAttribute('data-name');
            const productPrice = productItem.getAttribute('data-price');

            const product = {
                id: productId,
                name: productName,
                price: productPrice
            };

            cart.push(product);
            cartCount.innerText = cart.length;
            localStorage.setItem('cart', JSON.stringify(cart));

            alert(productName + ' has been added to your cart.');
        });
    });

    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
        cartCount.innerText = cart.length;
    }
});
