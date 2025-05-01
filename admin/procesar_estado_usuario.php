<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['accion'])) {
    include '../php/db.php';

    $user_id = $_GET['id'];
    $accion = $_GET['accion'];
    $nuevo_estado = ($accion === 'activar') ? 1 : 0;

    $stmt = $conn->prepare("UPDATE usuarios SET activo = ? WHERE id = ?");
    $stmt->bind_param("ii", $nuevo_estado, $user_id);

    if ($stmt->execute()) {
        header("Location: index.php"); // Redirigir de vuelta a la lista de usuarios
        exit();
    } else {
        // Puedes añadir un mensaje de error a la sesión si lo deseas
        $_SESSION['error_estado_usuario'] = "Error al cambiar el estado del usuario.";
        header("Location: index.php");
        exit();
    }

    $stmt->close();
    $conn->close();

} else {
    // Si faltan parámetros en la URL, redirigir a la lista de usuarios
    header("Location: index.php");
    exit();
}
?>