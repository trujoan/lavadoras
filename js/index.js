document.addEventListener('DOMContentLoaded', () => {
    const sliders = document.querySelectorAll('.image-slider');
    const filterSelect = document.getElementById('filter');
    const productList = document.querySelector('.product-list');
    const cartItemsList = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');

    const products = Array.from(productList.children);
    let cart = [];

    // Slider de imágenes
    sliders.forEach(slider => {
        const images = slider.querySelectorAll('img');
        let currentIndex = 0;

        // Mostrar la primera imagen
        images[currentIndex].style.opacity = 1;

        // Cambiar la imagen cada 3 segundos
        setInterval(() => {
            images[currentIndex].classList.remove('active');
            images[currentIndex].style.opacity = 0;

            currentIndex = (currentIndex + 1) % images.length;

            images[currentIndex].classList.add('active');
            images[currentIndex].style.opacity = 1;
        }, 3000);
    });

    // Filtrado de productos
    filterSelect.addEventListener('change', (event) => {
        const filterValue = event.target.value;

        // Clonar la lista de productos
        let sortedProducts = [...products];

        if (filterValue === 'az') {
            sortedProducts.sort((a, b) => a.querySelector('h3').innerText.localeCompare(b.querySelector('h3').innerText));
        } else if (filterValue === 'za') {
            sortedProducts.sort((a, b) => b.querySelector('h3').innerText.localeCompare(a.querySelector('h3').innerText));
        } else if (filterValue === 'low-to-high') {
            sortedProducts.sort((a, b) => {
                const priceA = parseInt(a.querySelector('.price').innerText.replace(/\D/g, ''));
                const priceB = parseInt(b.querySelector('.price').innerText.replace(/\D/g, ''));
                return priceA - priceB;
            });
        } else if (filterValue === 'high-to-low') {
            sortedProducts.sort((a, b) => {
                const priceA = parseInt(a.querySelector('.price').innerText.replace(/\D/g, ''));
                const priceB = parseInt(b.querySelector('.price').innerText.replace(/\D/g, ''));
                return priceB - priceA;
            });
        }

        // Limpiar el listado de productos y agregar los ordenados
        productList.innerHTML = '';
        sortedProducts.forEach(product => productList.appendChild(product));
    });

    // Agregar productos al carrito
    productList.addEventListener('click', (event) => {
        if (event.target.tagName === 'BUTTON') { // Cambiado a 'BUTTON' para capturar el botón
            const product = event.target.closest('.product');
            const productName = product.querySelector('h3').innerText;
            const productPrice = parseInt(product.querySelector('.price').innerText.replace(/\D/g, ''));

            cart.push({ name: productName, price: productPrice });
            updateCart();
        }
    });

    function updateCart() {
        cartItemsList.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            const li = document.createElement('li');
            li.innerText = `${item.name} - $${item.price}`;
            cartItemsList.appendChild(li);
            total += item.price;
        });

        cartTotal.innerText = `Total: $${total}`;
    }
});
