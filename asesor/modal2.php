<?php session_start(); $_SESSION = array_merge($_SESSION, $_POST); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Beneficiarios</title>
  <link rel="stylesheet" href="../css/styles.css">
  <script>
    function agregarBeneficiario() {
      const contenedor = document.getElementById('beneficiarios');
      const nuevo = document.createElement('div');
      nuevo.innerHTML = `
        <input type="text" name="beneficiario_nombre[]" placeholder="Nombre y Apellido" required>
        <select name="beneficiario_relacion[]" required>
          <option value="">Relación</option>
          <option value="Conyugue">Conyugue</option>
          <option value="Hijo">Hijo</option>
          <option value="Otro">Otro</option>
        </select>
      `;
      contenedor.appendChild(nuevo);
    }
  </script>
</head>
<body class="apple-style">
  <div class="form-container">
    <h2>Beneficiarios</h2>
    <form method="POST" action="final.php">
      <div id="beneficiarios">
        <div>
          <input type="text" name="beneficiario_nombre[]" placeholder="Nombre y Apellido" required>
          <select name="beneficiario_relacion[]" required>
            <option value="">Relación</option>
            <option value="Conyugue">Conyugue</option>
            <option value="Hijo">Hijo</option>
            <option value="Otro">Otro</option>
          </select>
        </div>
      </div>
      <button type="button" onclick="agregarBeneficiario()">+ Agregar otro</button>
      <br><br>
      <button type="submit">Guardar todo</button>
    </form>
  </div>
  
</body>
</html>
