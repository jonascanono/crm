<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es superusuario
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Usuario</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-container {
            background: #ffffff;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 700px;
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #1e7e34;
        }

        .error-message {
            color: red;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Crear Nuevo Usuario</h2>
        <?php
        if (isset($_SESSION['error_crear_usuario'])) {
            echo '<p class="error-message">' . $_SESSION['error_crear_usuario'] . '</p>';
            unset($_SESSION['error_crear_usuario']);
        }
        ?>
        <form action="procesar_crear_usuario.php" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="">Seleccionar Rol</option>
                <option value="superusuario">Superusuario</option>
                <option value="asesor">Asesor</option>
            </select>

            <button type="submit">Crear Usuario</button>
        </form>
        <p><a href="index.php">Volver a la lista de usuarios</a></p>
    </div>
</body>
</html>