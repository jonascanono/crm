<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRM Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body class="apple-style">
    <div class="login-container">
        <h2>Iniciar sesión</h2>
        <?php
        if (isset($_SESSION['error_login'])) {
            echo '<p style="color: red;">' . $_SESSION['error_login'] . '</p>';
            unset($_SESSION['error_login']);
        }
        ?>
        <form action="../php/login_process.php" method="POST">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
