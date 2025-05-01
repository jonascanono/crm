<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../php/db.php';

    $user_id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    // Verificar si el nuevo correo ya existe para otro usuario (excluyendo el usuario actual)
    $stmt_check = $conn->prepare("SELECT correo FROM usuarios WHERE correo = ? AND id != ?");
    $stmt_check->bind_param("si", $correo, $user_id);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['error_editar_usuario'] = "El correo electrónico ya está registrado por otro usuario.";
        header("Location: editar_usuario.php?id=" . $user_id);
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    // Actualizar la información del usuario
    $stmt_update = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, rol = ? WHERE id = ?");
    $stmt_update->bind_param("sssi", $nombre, $correo, $rol, $user_id);

    if ($stmt_update->execute()) {
        header("Location: index.php"); // Redirigir a la lista de usuarios después de la edición
        exit();
    } else {
        $_SESSION['error_editar_usuario'] = "Error al guardar los cambios del usuario: " . $stmt_update->error;
        header("Location: editar_usuario.php?id=" . $user_id);
    }

    $stmt_update->close();
    $conn->close();

} else {
    // Si se intenta acceder directamente a este script, redirigir a la lista de usuarios
    header("Location: index.php");
    exit();
}
?>