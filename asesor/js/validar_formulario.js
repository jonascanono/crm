formularioCliente.addEventListener('submit', function(event) {
    console.log('Se ha intentado enviar el formulario.');
    let hasErrors = false;

    // Validar campo Nombre
    if (nombreInput.value.trim() === '') {
        displayError(nombreInput.id, 'Este campo es obligatorio.');
        hasErrors = true;
    } else if (nombreInput.value.trim().length < 2 || nombreInput.value.trim().length > 50) {
        displayError(nombreInput.id, 'Debe tener entre 2 y 50 caracteres.');
        hasErrors = true;
    } else {
        clearError(nombreInput.id);
    }
    console.log('Validación Nombre - Valor:', nombreInput.value, 'hasErrors:', hasErrors);

    // Validar campo Apellidos
    if (apellidosInput.value.trim() === '') {
        displayError(apellidosInput.id, 'Este campo es obligatorio.');
        hasErrors = true;
    } else if (apellidosInput.value.trim().length < 2 || apellidosInput.value.trim().length > 50) {
        displayError(apellidosInput.id, 'Debe tener entre 2 y 50 caracteres.');
        hasErrors = true;
    } else {
        clearError(apellidosInput.id);
    }
    console.log('Validación Apellidos - Valor:', apellidosInput.value, 'hasErrors:', hasErrors);

    // Validar campo Dirección (solo obligatorio)
    const direccionInput = document.getElementById('direccion');
    if (direccionInput.value.trim() === '') {
        displayError(direccionInput.id, 'Este campo es obligatorio.');
        hasErrors = true;
    } else {
        clearError(direccionInput.id);
    }
    console.log('Validación Dirección - Valor:', direccionInput.value, 'hasErrors:', hasErrors);

    // Validar campo Teléfono (obligatorio y 10 dígitos)
    if (telefonoInput.value.trim() === '') {
        displayError(telefonoInput.id, 'El teléfono es obligatorio.');
        hasErrors = true;
    } else if (!/^\d{10}$/.test(telefonoInput.value.trim())) {
        displayError(telefonoInput.id, 'El teléfono debe tener 10 dígitos numéricos.');
        hasErrors = true;
    } else {
        clearError(telefonoInput.id);
    }
    console.log('Validación Teléfono - Valor:', telefonoInput.value, 'hasErrors:', hasErrors);

    // Validar Nacionalidad (obligatorio)
    if (document.getElementById('nacionalidad').value === '') {
        displayError('nacionalidad', 'Por favor, selecciona una nacionalidad.');
        hasErrors = true;
    } else {
        clearError('nacionalidad');
    }
    console.log('Validación Nacionalidad - Valor:', document.getElementById('nacionalidad').value, 'hasErrors:', hasErrors);

    // Validar Status Legal (obligatorio)
    if (document.getElementById('status_legal').value === '') {
        displayError('status_legal', 'Por favor, selecciona un status legal.');
        hasErrors = true;
    } else {
        clearError('status_legal');
    }
    console.log('Validación Status Legal - Valor:', document.getElementById('status_legal').value, 'hasErrors:', hasErrors);

    // Validar Código Postal (obligatorio y 5 dígitos)
    if (codigoPostalInput.value.trim() === '') {
        displayError(codigoPostalInput.id, 'El código postal es obligatorio.');
        hasErrors = true;
    } else if (!/^\d{5}$/.test(codigoPostalInput.value.trim())) {
        displayError(codigoPostalInput.id, 'El código postal debe tener 5 dígitos numéricos.');
        hasErrors = true;
    } else {
        clearError(codigoPostalInput.id);
    }
    console.log('Validación Código Postal - Valor:', codigoPostalInput.value, 'hasErrors:', hasErrors);

    // Validar Fecha de Nacimiento (obligatorio)
    // Validar Fecha de Nacimiento (obligatorio)
    if (document.getElementById('fecha_nacimiento').value === '') {
        displayError('fecha_nacimiento', 'La fecha de nacimiento es obligatoria.');
        hasErrors = true;
    } else {
        clearError('fecha_nacimiento');
    }
    console.log('Validación Fecha Nacimiento - Valor:', document.getElementById('fecha_nacimiento').value, 'hasErrors:', hasErrors);
    

    console.log('Valor final de hasErrors:', hasErrors);
    if (hasErrors) {
        event.preventDefault();
        console.log('Envío del formulario prevenido.');
    } else {
        console.log('El formulario se enviará.');
    }
});