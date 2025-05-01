<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es asesor
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'asesor') {
    header("Location: ../public/login.php"); // Ajusta la ruta si es necesario
    exit();
}

// Incluir la conexión a la base de datos
include('../php/db.php');

// Obtener el ID del asesor de la sesión
$asesor_id = $_SESSION['usuario_id'];

// Consulta para obtener los clientes asociados al asesor
$sql = "SELECT id, nombre, apellidos, estado_venta FROM clientes WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $asesor_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Clientes</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .client-list-container {
            background: #ffffff;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 800px;
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .client-list {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .client-list th, .client-list td {
            border: 1px solid #e0e0e0;
            padding: 0.75rem 1rem;
            text-align: left;
        }

        .client-list th {
            background-color: #f0f0f0;
            font-weight: bold;
            color: #333;
        }

        .client-list tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .no-clients {
            text-align: center;
            padding: 1rem;
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body class="apple-style">
    <div class="client-list-container">
        <h2>Mis Clientes</h2>

        <?php if ($result->num_rows > 0): ?>
            <table class="client-list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Estado_Venta</th>
                        </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['apellidos']; ?></td>
                            <td><?php echo $row['estado_venta']; ?></td>
                            
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-clients">No tienes clientes asignados aún.</p>
        <?php endif; ?>

        <p><a href="index.php">Volver al Módulo del Asesor</a></p>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$stmt->close();
$conn->close();
?>