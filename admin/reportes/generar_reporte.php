<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php");
    exit();
}

include '../../php/db.php';

// Obtener los filtros del formulario
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];
$asesor_id = $_GET['asesor'];
$estado_venta_filtro = $_GET['estado_venta'];

echo "Fecha Inicio: " . $fecha_inicio . "<br>";
echo "Fecha Fin: " . $fecha_fin . "<br>";
echo "Asesor ID: " . $asesor_id . "<br>";
echo "Estado Venta: " . $estado_venta_filtro . "<br>";

// Construir la consulta SQL (¡ADAPTADA PARA FILTROS OPCIONALES!)
$sql = "SELECT
            c.id AS cliente_id,
            c.created_at AS fecha_venta,
            c.estado_venta AS estado,
            c.nombre AS cliente_nombre,
            c.apellidos AS cliente_apellido,
            u.nombre AS asesor_nombre,
            c.audio_path
        FROM
            clientes c
        INNER JOIN
            usuarios u ON c.usuario = u.id
        WHERE 1=1";

if ($fecha_inicio != "") {
    $sql .= " AND c.created_at >= '$fecha_inicio 00:00:00'";
}

if ($fecha_fin != "") {
    $sql .= " AND c.created_at <= '$fecha_fin 23:59:59'";
}

if ($asesor_id != "") {
    $sql .= " AND c.usuario = '$asesor_id'";
}

if ($estado_venta_filtro != "") {
    $sql .= " AND c.estado_venta = '$estado_venta_filtro'";
}

echo "<br>Consulta SQL: " . $sql . "<br>";  // Imprimir la consulta
//exit;  // Detener la ejecución para ver la consulta

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Reporte</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Resultado del Reporte</h2>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Cliente ID</th>
                        <th>Fecha Venta</th>
                        <th>Estado Venta</th>
                        <th>Cliente Nombre</th>
                        <th>Cliente Apellido</th>
                        <th>Asesor</th>
                        <th>Audio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr <?php if ($row['audio_path'] == null) echo 'class="sin-audio"'; ?>>
                            <td><?php echo $row['cliente_id']; ?></td>
                            <td><?php echo $row['fecha_venta']; ?></td>
                            <td><?php echo $row['estado']; ?></td>
                            <td><?php echo $row['cliente_nombre']; ?></td>
                            <td><?php echo $row['cliente_apellido']; ?></td>
                            <td><?php echo $row['asesor_nombre']; ?></td>
                            <td>
                                <?php if ($row['audio_path'] != null): ?>
                                    <a href="<?php echo $row['audio_path']; ?>" target="_blank">Ver Audio</a>
                                <?php else: ?>
                                    Sin Audio
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron clientes con los criterios seleccionados.</p>
        <?php endif; ?>

        <p><a href="index.php">Volver al Módulo de Reportes</a></p>
    </div>
</body>
</html>