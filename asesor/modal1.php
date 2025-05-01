<?php session_start(); $_SESSION = array_merge($_SESSION, $_POST); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Datos Bancarios</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="apple-style">
  <div class="form-container">
    <h2>Datos Bancarios</h2>
    <form method="POST" action="modal2.php" >
      <div class="row">
        <div class="column">
          <label for="cuenta">Número de Cuenta</label>
          <input type="text" id="cuenta" name="cuenta" required>

          <label for="banco">Banco</label>
          <input type="text" id="banco" name="banco" required>
        </div>
        <div class="column">
          <label for="ruta">Ruta</label>
          <input type="text" id="ruta" name="ruta" required>

          <label for="identificacion">Identificación</label>
          <input type="text" id="identificacion" name="identificacion" required>
        </div>
      </div>
      <button type="submit">Continuar</button>
    </form>
  </div>
  
</body>
</html>
