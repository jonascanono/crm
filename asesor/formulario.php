<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="apple-style">
  <div class="form-container">
    <h2>Formulario de Cliente</h2>
    <form method="POST" action="modal1.php" class="asesor-form" id="formulario-cliente">
      <input type="hidden" name="usuario" value="<?php echo $_SESSION['usuario']; ?>">
      <div class="row">
        <div class="column">
          <label for="nombre"></label>
          <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>

          <label for="apellidos"></label>
          <input type="text" id="apellidos" name="apellidos" placeholder="Apellidos" required>

          <label for="direccion"></label>
          <input type="text" id="direccion" name="direccion" placeholder="Direccion" required>

          <label for="telefono"></label>
          <input type="text" id="telefono" name="telefono" placeholder="Telefono" required>
        </div>
        <div class="column">
          <label for="nacionalidad"></label>
          <select id="nacionalidad" name="nacionalidad" placeholder="nacionalaidad" required>
            <option value="">Nacionalidad</option>
        <option value="Argentina">Argentina</option>
        <option value="Bolivia">Bolivia</option>
        <option value="Brasil">Brasil</option>
        <option value="Chile">Chile</option>
        <option value="Colombia">Colombia</option>
        <option value="Ecuador">Ecuador</option>
        <option value="Guyana">Guyana</option>
        <option value="Paraguay">Paraguay</option>
        <option value="Perú">Perú</option>
        <option value="Surinam">Surinam</option>
        <option value="Uruguay">Uruguay</option>
        <option value="Venezuela">Venezuela</option>
        <option value="México">México</option>
        <option value="Guatemala">Guatemala</option>
        <option value="Honduras">Honduras</option>
        <option value="El Salvador">El Salvador</option>
        <option value="Nicaragua">Nicaragua</option>
        <option value="Costa Rica">Costa Rica</option>
        <option value="Panamá">Panamá</option>
        <option value="Cuba">Cuba</option>
        <option value="República Dominicana">República Dominicana</option>
        <option value="Haití">Haití</option>
        <option value="Puerto Rico">Puerto Rico</option>
        <option value="Jamaica">Jamaica</option>
        <option value="Belice">Belice</option>

            
            <!-- Más opciones -->
          </select>

          <label for="status_legal"></label>
          <select id="status_legal" name="status_legal" placeholder="Status" required>
            <option value="">Status Legal</option>
            <option value="Ciudadano">Ciudadano</option>
            <option value="Residente">Residente</option>
            <option value="Permiso de trabajo">Permiso de trabajo</option>
            <option value="Otro">Otro</option>
            <!-- Más opciones -->
          </select>

          
      <label for="codigo_postal"></label>
    <input type="text" id="codigo_postal" name="codigo_postal" placeholder="Codigo Posta" required>
    <span class="error-message" id="codigo_postal-error"></span>



          <label for="fecha_nacimiento"></label>
          <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Cumpleaños" required>
        </div>
      </div>

      <button type="submit">Continuar</button>
    </form>
  </div>
  
</body>
</html>
