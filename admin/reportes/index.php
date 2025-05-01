<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php");
    exit();
}

include '../../php/db.php';

// Consulta para obtener la lista de asesores (para el filtro)
$sql_asesores = "SELECT id, nombre FROM usuarios WHERE rol = 'asesor'";
$result_asesores = $conn->query($sql_asesores);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Reportes</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Módulo de Reportes</h2>

        <form action="generar_reporte.php" method="GET" class="report-form">
            <label for="fecha_inicio">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" name="fecha_inicio">

            <label for="fecha_fin">Fecha Fin:</label>
            <input type="date" id="fecha_fin" name="fecha_fin">

            <label for="asesor">Asesor:</label>
            <select id="asesor" name="asesor">
                <option value="">Todos los Asesores</option>
                <?php
                if ($result_asesores->num_rows > 0) {
                    while ($row_asesor = $result_asesores->fetch_assoc()) {
                        echo '<option value="' . $row_asesor['id'] . '">' . $row_asesor['nombre'] . '</option>';
                    }
                }
                ?>
            </select>

            <label for="estado_venta">Estado Venta:</label>
            <select id="estado_venta" name="estado_venta">
                <option value="">Todos los Estados</option>
                <option value="pendiente">Pendiente</option>
                <option value="aprobada">Aprobada</option>
                <option value="rechazada">Rechazada</option>
            </select>

            <label for="sin_audio">Mostrar sin Audio:</label>
            <select id="sin_audio" name="sin_audio">
                <option value="">Todos</option>
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>

            <button type="submit">Generar Reporte</button>
        </form>

        <div class="report-container">
            </div>

        <p><a href="../index.php">Volver al Panel de Administración</a></p>
    </div>
</body>
</html>