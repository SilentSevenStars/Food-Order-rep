window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    header.classList.toggle('scrolled', window.scrollY > 0);
});
function showDetails(item) {
    item.querySelector('.product-details').style.display = 'block';
}

function hideDetails(item) {
    item.querySelector('.product-details').style.display = 'none';
}

function addToCart() {
    // Implement your add to cart functionality here
    alert('Product added to cart!');
}
function addToCart(productId) {
    const product = document.getElementById(productId);
    const productName = product.querySelector('h3').innerText;
    const productPrice = product.querySelector('p:nth-of-type(1)').innerText.split(': ')[1];
    const productCategory = product.querySelector('p:nth-of-type(2)').innerText.split(': ')[1];
    const productQuantity = parseInt(document.getElementById(`quantity${productId.slice(-1)}`).value);

    const cartItem = {
        name: productName,
        price: productPrice,
        category: productCategory,
        quantity: productQuantity
    };

    // Add the item to the cart
    const cart = document.getElementById('cart-items');
    const li = document.createElement('li');
    li.innerText = `${cartItem.name} - ${cartItem.quantity} x ${cartItem.price}`;
    cart.appendChild(li);
}

function checkout() {
    // Perform checkout logic here
    alert('Checkout completed!');
}