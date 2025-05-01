document.addEventListener('DOMContentLoaded', function() {
    const formularioBeneficiarios = document.getElementById('formulario-beneficiarios');
    const beneficiariosContainer = document.getElementById('beneficiarios');
    const agregarBeneficiarioButton = document.querySelector('#formulario-beneficiarios button[type="button"]');

    function agregarBeneficiarioInterno() {
        const contenedor = document.getElementById('beneficiarios');
        const nuevo = document.createElement('div');
        nuevo.innerHTML = `
            <input type="text" name="beneficiario_nombre[]" placeholder="Nombre y Apellido" required minlength="2" maxlength="50">
            <span class="error-message beneficiario-nombre-error"></span>
            <select name="beneficiario_relacion[]" required>
                <option value="">Relación</option>
                <option value="Conyugue">Conyugue</option>
                <option value="Hijo">Hijo</option>
                <option value="Otro">Otro</option>
            </select>
            <span class="error-message beneficiario-relacion-error"></span>
        `;
        contenedor.appendChild(nuevo);
    }

    formularioBeneficiarios.addEventListener('submit', function(event) {
        let hasErrors = false;
        const nombres = document.querySelectorAll('#beneficiarios input[name="beneficiario_nombre[]"]');
        const relaciones = document.querySelectorAll('#beneficiarios select[name="beneficiario_relacion[]"]');
        const nombreErrorMessages = document.querySelectorAll('.beneficiario-nombre-error');
        const relacionErrorMessages = document.querySelectorAll('.beneficiario-relacion-error');

        nombres.forEach((nombreInput, index) => {
            if (nombreInput.value.trim() === '') {
                nombreErrorMessages[index].textContent = 'El nombre es obligatorio.';
                hasErrors = true;
            } else if (nombreInput.value.trim().length < 2 || nombreInput.value.trim().length > 50) {
                nombreErrorMessages[index].textContent = 'Debe tener entre 2 y 50 caracteres.';
                hasErrors = true;
            } else {
                nombreErrorMessages[index].textContent = '';
            }

            if (relaciones[index].value === '') {
                relacionErrorMessages[index].textContent = 'La relación es obligatoria.';
                hasErrors = true;
            } else {
                relacionErrorMessages[index].textContent = '';
            }
        });

        if (nombres.length === 0) {
            const primerNombreError = document.querySelector('#beneficiarios .beneficiario-nombre-error');
            if (primerNombreError) primerNombreError.textContent = 'Debe agregar al menos un beneficiario.';
            hasErrors = true;
        }

        if (hasErrors) {
            event.preventDefault();
        }
    });

    if (agregarBeneficiarioButton) {
        agregarBeneficiarioButton.addEventListener('click', agregarBeneficiarioInterno);
    }
});