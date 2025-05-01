<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es superusuario
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../php/db.php';

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena']; // ¡En un entorno real, hashear esta contraseña!
    $rol = $_POST['rol'];
    $fecha_creacion = date("Y-m-d H:i:s");

    // Verificar si el correo ya existe
    $stmt_check = $conn->prepare("SELECT correo FROM usuarios WHERE correo = ?");
    $stmt_check->bind_param("s", $correo);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $_SESSION['error_crear_usuario'] = "El correo electrónico ya está registrado.";
        header("Location: crear_usuario.php");
        $stmt_check->close();
        $conn->close();
        exit();
    }
    $stmt_check->close();

    // Insertar el nuevo usuario
    $stmt_insert = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña, rol, fecha_creacion) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("sssss", $nombre, $correo, $contrasena, $rol, $fecha_creacion); // ¡No olvides el hashing de la contraseña!

    if ($stmt_insert->execute()) {
        header("Location: index.php"); // Redirigir a la lista de usuarios después de la creación
        exit();
    } else {
        $_SESSION['error_crear_usuario'] = "Error al crear el usuario: " . $stmt_insert->error;
        header("Location: crear_usuario.php");
    }

    $stmt_insert->close();
    $conn->close();

} else {
    // Si se intenta acceder directamente a este script, redirigir a la página de creación de usuarios
    header("Location: crear_usuario.php");
    exit();
}
?>