document.addEventListener('DOMContentLoaded', function() {
    const formularioBancario = document.getElementById('formulario-bancario');
    const cuentaInput = document.getElementById('cuenta');
    const rutaInput = document.getElementById('ruta');
    const identificacionInput = document.getElementById('identificacion');
//    const requiredInputs = formularioBancario.querySelectorAll('input[type="text"][required]');

    function displayError(elementId, message) {
        const errorElement = document.getElementById(elementId + '-error');
        if (errorElement) {
            errorElement.textContent = message;
        }
    }

    function clearError(elementId) {
        const errorElement = document.getElementById(elementId + '-error');
        if (errorElement) {
            errorElement.textContent = '';
        }
    }

    formularioBancario.addEventListener('submit', function(event) {
        let hasErrors = false;

        requiredInputs.forEach(input => {
            if (input.value.trim() === '') {
                displayError(input.id, 'Este campo es obligatorio.');
                hasErrors = true;
            } else {
                clearError(input.id);
            }
        });

        // Validar número de cuenta
        if (cuentaInput.value.trim() === '') {
            displayError('cuenta', 'El número de cuenta es obligatorio.');
            hasErrors = true;
        } else if (!/^\d{5,15}$/.test(cuentaInput.value.trim())) {
            displayError('cuenta', 'Debe tener entre 5 y 15 dígitos numéricos.');
            hasErrors = true;
        } else {
            clearError('cuenta');
        }

        // Validar ruta
        if (rutaInput.value.trim() === '') {
            displayError('ruta', 'La ruta es obligatoria.');
            hasErrors = true;
        } else if (!/^\d{5,15}$/.test(rutaInput.value.trim())) {
            displayError('ruta', 'Debe tener entre 5 y 15 dígitos numéricos.');
            hasErrors = true;
        } else {
            clearError('ruta');
        }

        // Validar identificación
        if (identificacionInput.value.trim() === '') {
            displayError('identificacion', 'La identificación es obligatoria.');
            hasErrors = true;
        } else if (!/^\d{5,15}$/.test(identificacionInput.value.trim())) {
            displayError('identificacion', 'Debe tener entre 5 y 15 dígitos numéricos.');
            hasErrors = true;
        } else {
            clearError('identificacion');
        }

        if (hasErrors) {
            event.preventDefault();
        }
    });
});