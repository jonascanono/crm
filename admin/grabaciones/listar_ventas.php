<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php");
    exit();
}

include '../../php/db.php';

$sql = "SELECT id, nombre, apellidos, telefono, created_at, usuario, estado_venta FROM clientes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Ventas</title>
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .admin-container {
            background: #fff;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 90%;
            overflow-x: auto;
        }
        h2 { text-align: center; margin-bottom: 1.5rem; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.75rem; text-align: left; }
        th { background-color: #f0f0f0; }
        a.button {
            background: #007bff;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            margin-right: 0.5rem;
            display: inline-block;
        }
        a.button:hover { background: #0056b3; }
        .volver-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            background-color: #6c757d;
            color: white;
            padding: 0.5rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Listado de Ventas</h2>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <p style="color: green;"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre'] . ' ' . $row['apellidos']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['usuario']; ?></td>
                            <td><?php echo $row['estado_venta']; ?></td>
                            <td>
                                <a class="button" href="cargar_audio.php?venta_id=<?php echo $row['id']; ?>">Subir Audio</a>
                                <a class="button" href="../actualizar_estado_venta.php?id=<?php echo $row['id']; ?>">Actualizar Estado</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay ventas registradas.</p>
        <?php endif; ?>

        <a href="../index.php" class="volver-link">Volver al Panel</a>
    </div>
</body>
</html>
