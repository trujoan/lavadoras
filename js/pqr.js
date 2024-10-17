document.addEventListener('DOMContentLoaded', () => {
    const maintenanceForm = document.getElementById('maintenance-request');
    const pqrForm = document.getElementById('pqr-request');
    const trackingButton = document.getElementById('track-button');
    const trackingResult = document.getElementById('tracking-result');

    maintenanceForm.addEventListener('submit', (event) => {
        event.preventDefault();
        alert('Solicitud de mantenimiento enviada.');
        maintenanceForm.reset();
    });

    pqrForm.addEventListener('submit', (event) => {
        event.preventDefault();
        alert('PQR enviada.');
        pqrForm.reset();
    });

    trackingButton.addEventListener('click', () => {
        const trackingId = document.getElementById('tracking-id').value;
        // Aquí deberías implementar la lógica para buscar el estado del PQR con el ID proporcionado
        trackingResult.textContent = `Estado de la PQR con ID ${trackingId}: En proceso...`;
    });
});
