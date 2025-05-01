<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../public/login.php");
    exit();
}

include '../php/db.php';

$sql = "SELECT id, nombre, correo, rol, fecha_creacion, activo FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .admin-container {
            background: #ffffff;
            padding: 2rem;
            margin: 2rem auto;
            border-radius: 16px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 900px; /* Aumentamos el ancho para el menú */
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .menu-admin {
            background-color: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .menu-admin ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem;
        }

        .menu-admin ul li a {
            text-decoration: none;
            color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .menu-admin ul li a:hover {
            background-color: #e9ecef;
        }

        .menu-admin .dropdown {
            position: relative;
        }

        .menu-admin .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 0.25rem;
        }

        .menu-admin .dropdown-content a {
            color: black;
            padding: 0.75rem 1rem;
            text-decoration: none;
            display: block;
        }

        .menu-admin .dropdown-content a:hover {
            background-color: #ddd;
        }

        .menu-admin .dropdown:hover .dropdown-content {
            display: block;
        }

        .user-list th, .user-list td {
            border: 1px solid #ccc;
            padding: 0.75rem;
            text-align: left;
        }

        .user-list th {
            background-color: #f0f0f0;
        }

        .action-buttons button, .action-buttons a { /* Añadimos estilo para los enlaces como botones */
            padding: 0.5rem 1rem;
            margin-right: 0.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none; /* Para que los enlaces parezcan botones */
            display: inline-block; /* Para que los estilos de padding y margin funcionen */
        }

        .edit-button {
            background-color: #007bff;
            color: white;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
        }

        .activate-button {
            background-color: #28a745;
            color: white;
        }

        .deactivate-button {
            background-color: #ffc107;
            color: #212529;
        }

        .status-active {
            color: green;
            font-weight: bold;
        }

        .status-inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Administración del Sistema</h2>

        <nav class="menu-admin">
            <ul>
                <li class="dropdown">
                    <a href="#">Usuarios</a>
                    <div class="dropdown-content">
                        <a href="index.php">Listar Usuarios</a>
                        <a href="crear_usuario.php">Crear Usuario</a>
                    </div>
                </li>
                <li class="dropdown">
                    <a href="#">Grabaciones</a>
                    <div class="dropdown-content">
                        <a href="grabaciones/listar_ventas.php">Listar Ventas</a>
                        <a href="grabaciones/subir_archivo.php">Subir Archivo</a>
                    </div>
                </li>
                <li><a href="reportes/index.php">Reportes</a></li>
            </ul>
        </nav>

        <h3>Lista de Usuarios</h3>
        <?php if ($result->num_rows > 0): ?>
            <table class="user-list">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Fecha de Creación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['correo']; ?></td>
                            <td><?php echo $row['rol']; ?></td>
                            <td><?php echo $row['fecha_creacion']; ?></td>
                            <td>
                                <?php
                                if ($row['activo']) {
                                    echo '<span class="status-active">Activo</span>';
                                } else {
                                    echo '<span class="status-inactive">Inactivo</span>';
                                }
                                ?>
                            </td>
                            <td class="action-buttons">
                                <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="edit-button">Editar</a>
                                <a href="procesar_eliminar_usuario.php?id=<?php echo $row['id']; ?>" class="delete-button" onclick="return confirm('¿Estás seguro de que deseas eliminar a este usuario?');">Eliminar</a>
                                <?php if ($row['activo']): ?>
                                    <a href="procesar_estado_usuario.php?id=<?php echo $row['id']; ?>&accion=inactivar" class="deactivate-button">Inactivar</a>
                                <?php else: ?>
                                    <a href="procesar_estado_usuario.php?id=<?php echo $row['id']; ?>&accion=activar" class="activate-button">Activar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron usuarios.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>