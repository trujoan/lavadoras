document.addEventListener('DOMContentLoaded', () => {
    loadConsultasServicios();
    loadEstadoCompras();
    loadHistorial();
});

function loadConsultasServicios() {
    const serviciosList = document.getElementById('servicios-list');
    // Simulación de datos, normalmente esto vendría de una API
    const servicios = [
        'Servicio de Mantenimiento A',
        'Servicio de Mantenimiento B',
        'Servicio de Mantenimiento C'
    ];

    servicios.forEach(servicio => {
        const div = document.createElement('div');
        div.textContent = servicio;
        serviciosList.appendChild(div);
    });
}

function loadEstadoCompras() {
    const estadoCompras = document.getElementById('estado-compras');
    // Simulación de datos
    const estados = [
        'Compra 1: En Proceso',
        'Compra 2: Completada',
        'Compra 3: En Espera'
    ];

    estados.forEach(estado => {
        const div = document.createElement('div');
        div.textContent = estado;
        estadoCompras.appendChild(div);
    });
}

function loadHistorial() {
    const historialList = document.getElementById('historial-list');
    // Simulación de datos
    const historial = [
        'Compra 1 - Lavadora A - $500',
        'Compra 2 - Lavadora B - $600',
        'Servicio de Mantenimiento - $150'
    ];

    historial.forEach(item => {
        const div = document.createElement('div');
        div.textContent = item;
        historialList.appendChild(div);
    });
}
