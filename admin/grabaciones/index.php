<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php"); // Ajusta la ruta si es necesario
    exit();
}

include '../../php/db.php'; // Ajusta la ruta si es necesario

// Aquí podrías tener lógica para obtener la lista inicial de ventas
// o mostrar un mensaje de bienvenida al módulo.

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Grabaciones</title>
    <link rel="stylesheet" href="../../css/styles.css"> </head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Módulo de Grabaciones</h2>

        <p>Aquí podrás gestionar las grabaciones de las ventas.</p>

        <a href="listar_ventas.php">Listar Ventas</a> | <a href="subir_archivo.php">Subir Archivo</a>

        </div>
</body>
</html>