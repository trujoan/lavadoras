document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('consulta-form').addEventListener('submit', actualizarConsulta);
    loadEstadoCompras();
    loadHistorial();
});

function actualizarConsulta(event) {
    event.preventDefault();

    const cedula = document.getElementById('cedula').value;
    const correo = document.getElementById('correo').value;
    const nOrden = document.getElementById('nOrden').value;
    const estatus = document.getElementById('estatus').value;
    const comentario = document.getElementById('comentario').value;

    // Aquí puedes enviar los datos a un servidor o realizar otra acción
    console.log('Consulta Actualizada:', { cedula, correo, nOrden, estatus, comentario });

    // Reseteo del formulario
    document.getElementById('consulta-form').reset();
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
