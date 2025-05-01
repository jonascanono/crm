<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php");
    exit();
}

include '../php/db.php';

// Validar el ID de la venta
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error_reporte'] = "ID de venta inválido.";
    header("Location: index.php");
    exit();
}

$id_venta = (int)$_GET['id'];  //  Castear a entero para mayor seguridad

// Obtener la información de la venta
$stmt = $conn->prepare("SELECT id, cliente_id, fecha_venta, usuario, estado FROM ventas WHERE id = ?");
$stmt->bind_param("i", $id_venta);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $venta = $result->fetch_assoc();
} else {
    $_SESSION['error_reporte'] = "Venta no encontrada.";
    header("Location: index.php");
    exit();
}
$stmt->close();

// Procesar la actualización del estado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar el nuevo estado
    $estados_permitidos = ['aprobada', 'pendiente', 'rechazada'];
    $nuevo_estado = $_POST['nuevo_estado'];

    if (!in_array($nuevo_estado, $estados_permitidos)) {
        $_SESSION['error_reporte'] = "Estado de venta no válido.";
        header("Location: actualizar_estado.php?id=" . $id_venta);
        exit();
    }

    $stmt_update = $conn->prepare("UPDATE ventas SET estado = ? WHERE id = ?");
    $stmt_update->bind_param("si", $nuevo_estado, $id_venta);

    if ($stmt_update->execute()) {
        $_SESSION['mensaje_reporte'] = "Estado de venta actualizado correctamente.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_reporte'] = "Error al actualizar el estado de la venta: " . $stmt_update->error;
        header("Location: actualizar_estado.php?id=" . $id_venta);
        exit();
    }

    $stmt_update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Estado Venta</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Actualizar Estado Venta</h2>

        <?php
        if (isset($_SESSION['error_reporte'])) {
            echo '<p class="error-message">' . $_SESSION['error_reporte'] . '</p>';
            unset($_SESSION['error_reporte']);
        }
        if (isset($_SESSION['mensaje_reporte'])) {
            echo '<p class="success-message">' . $_SESSION['mensaje_reporte'] . '</p>';
            unset($_SESSION['mensaje_reporte']);
        }
        ?>

        <form action="actualizar_estado.php?id=<?php echo htmlspecialchars($venta['id']); ?>" method="POST">
            <label for="nuevo_estado">Nuevo Estado:</label>
            <select id="nuevo_estado" name="nuevo_estado">
                <option value="aprobada" <?php if ($venta['estado'] == 'aprobada') echo 'selected'; ?>>Aprobada</option>
                <option value="pendiente" <?php if ($venta['estado'] == 'pendiente') echo 'selected'; ?>>Pendiente</option>
                <option value="rechazada" <?php if ($venta['estado'] == 'rechazada') echo 'selected'; ?>>Rechazada</option>
            </select>

            <div class="form-actions">
                <button type="submit">Actualizar Estado</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>