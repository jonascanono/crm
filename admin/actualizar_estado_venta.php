<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}

include '../php/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mensaje'] = "ID de venta inválido.";
    header("Location: grabaciones/listar_ventas.php");
    exit();
}

$id_venta = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_estado = $_POST['nuevo_estado'] ?? '';
    $estados_permitidos = ['pendiente', 'aprobada', 'rechazada'];

    if (!in_array($nuevo_estado, $estados_permitidos)) {
        $_SESSION['mensaje'] = "Estado de venta no válido.";
        header("Location: actualizar_estado_venta.php?id=" . $id_venta);
        exit();
    }

    $sql = "UPDATE clientes SET estado_venta = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nuevo_estado, $id_venta);

    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Estado actualizado correctamente.";
    } else {
        $_SESSION['mensaje'] = "Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: grabaciones/listar_ventas.php");
    exit();
}

$sql_estado = "SELECT estado_venta FROM clientes WHERE id = ?";
$stmt_estado = $conn->prepare($sql_estado);
$stmt_estado->bind_param("i", $id_venta);
$stmt_estado->execute();
$res = $stmt_estado->get_result();
$estado_actual = ($res->num_rows > 0) ? $res->fetch_assoc()['estado_venta'] : '';
$stmt_estado->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<!-- Dentro del <head> -->
<style>
    .admin-container {
        background: #fff;
        padding: 2rem;
        margin: 2rem auto;
        border-radius: 16px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        max-width: 500px;
    }

    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    select {
        width: 100%;
        padding: 0.5rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        margin-bottom: 1rem;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: block;
        width: 100%;
    }

    button:hover {
        background-color: #0056b3;
    }

    .volver-link {
        display: block;
        margin-top: 1rem;
        text-align: center;
        background-color: #6c757d;
        color: white;
        padding: 0.5rem;
        border-radius: 5px;
        text-decoration: none;
    }
</style>


    <meta charset="UTF-8">
    <title>Actualizar Estado</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Actualizar Estado de Venta</h2>
        <form method="POST" action="actualizar_estado_venta.php?id=<?php echo $id_venta; ?>">
            <label for="nuevo_estado">Nuevo Estado:</label>
            <select name="nuevo_estado" id="nuevo_estado" required>
                <option value="pendiente" <?php echo $estado_actual == 'pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                <option value="aprobada" <?php echo $estado_actual == 'aprobada' ? 'selected' : ''; ?>>Aprobada</option>
                <option value="rechazada" <?php echo $estado_actual == 'rechazada' ? 'selected' : ''; ?>>Rechazada</option>
            </select>
            <button type="submit">Actualizar</button>
        </form>
        <a href="grabaciones/listar_ventas.php" class="volver-link">Volver al Listado</a>
    </div>
</body>
</html>
