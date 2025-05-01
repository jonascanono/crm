<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['id'])) {
    include '../php/db.php';
    $user_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT id, nombre, correo, rol FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
    } else {
        $_SESSION['error_editar_usuario'] = "Usuario no encontrado.";
        header("Location: index.php");
        exit();
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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
        select {
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Editar Usuario</h2>
        <?php
        if (isset($_SESSION['error_editar_usuario'])) {
            echo '<p class="error-message">' . $_SESSION['error_editar_usuario'] . '</p>';
            unset($_SESSION['error_editar_usuario']);
        }
        ?>
        <form action="procesar_editar_usuario.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>" required>

            <label for="rol">Rol:</label>
            <select id="rol" name="rol" required>
                <option value="">Seleccionar Rol</option>
                <option value="superusuario" <?php if ($usuario['rol'] == 'superusuario') echo 'selected'; ?>>Superusuario</option>
                <option value="asesor" <?php if ($usuario['rol'] == 'asesor') echo 'selected'; ?>>Asesor</option>
            </select>

            <button type="submit">Guardar Cambios</button>
        </form>
        <p><a href="index.php">Volver a la lista de usuarios</a></p>
    </div>
</body>
</html>