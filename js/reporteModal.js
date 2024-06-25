document.addEventListener('DOMContentLoaded', function () {
    const options = document.querySelectorAll('.option');
    const downloadButton = document.getElementById('downloadButton');

    options.forEach(option => {
        option.addEventListener('click', function () {
            this.classList.toggle('selected');
        });
    });

    downloadButton.addEventListener('click', function () {
        const selectedOptions = document.querySelectorAll('.option.selected');
        const selectedTypes = Array.from(selectedOptions).map(option => option.getAttribute('data-type'));

        if (selectedTypes.length === 0) {
            alert('Seleccione al menos una opción para descargar.');
            return;
        }

        if (selectedTypes.includes('excel')) {
            // confirmar funciona btn excel (cambiar despues con ruta correcta)
            console.log('Descargar Excel');
        }

        if (selectedTypes.includes('pdf')) {
            // mismo de escel
            console.log('Descargar PDF');
        }

        $('#reporteModal').modal('hide');

        // quitar seleccion
        selectedOptions.forEach(option => {
            option.classList.remove('selected');
        });
    });
});
