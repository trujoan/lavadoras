document.addEventListener('DOMContentLoaded', () => {
    console.log("Página de Ofertas cargada.");

    const offerList = document.querySelector('.offer-list');

    // Obtener productos del localStorage
    const products = JSON.parse(localStorage.getItem('products')) || [];

    // Filtrar productos con descuento
    const discountedProducts = products.filter(product => product.descuento > 0);

    // Mostrar ofertas en el contenedor
    discountedProducts.forEach(product => {
        const productDiv = document.createElement('div');
        productDiv.classList.add('product');
        productDiv.innerHTML = `
            <img src="${product.imagen}" alt="${product.nombre}">
            <h3>${product.nombre}</h3>
            <p class="price">Precio Original: $${product.precio.toFixed(2)}</p>
            <p class="discount-price">Precio con Descuento: $${(product.precio - (product.precio * product.descuento / 100)).toFixed(2)}</p>
        `;
        offerList.appendChild(productDiv);
    });
});
