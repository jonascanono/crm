<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es asesor
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'asesor') {
    header("Location: ../public/login.php"); // Ajusta la ruta si es necesario
    exit();
}

// Obtener el nombre del asesor para mostrarlo en la página
$nombre_asesor = $_SESSION['usuario_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo del Asesor</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .menu-asesor {
            background-color: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .menu-asesor ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem;
            align-items: center; /* Para alinear verticalmente los elementos */
        }

        .menu-asesor ul li a {
            text-decoration: none;
            color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .menu-asesor ul li a:hover {
            background-color: #e9ecef;
        }

        .menu-asesor ul li:last-child {
            margin-left: auto; /* Empuja el último elemento a la derecha */
        }

        .menu-asesor ul li button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1rem;
        }

        .menu-asesor ul li button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body class="apple-style">
    <div class="admin-container">
        <h2>Bienvenido, <?php echo $nombre_asesor; ?></h2>
        <p>Aquí podrás gestionar tus clientes y ventas.</p>

        <nav class="menu-asesor">
            <ul>
                <li><a href="formulario.php">Crear Nuevo Cliente</a></li>
                <li><a href="listar_clientes.php">Listar Mis Clientes</a></li>
                <li>
                    <form action="../public/logout.php" method="post">
                        <button type="submit">Cerrar Sesión</button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</body>
</html><?php
session_start();

// Verificar si el usuario ha iniciado sesión y si su rol es asesor
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'asesor') {
    header("Location: ../public/login.php"); // Ajusta la ruta si es necesario
    exit();
}

// Obtener el nombre del asesor para mostrarlo en la página
$nombre_asesor = $_SESSION['usuario_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo del Asesor</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .menu-asesor {
            background-color: #f8f9fa;
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1.5rem;
        }

        .menu-asesor ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1rem;
        }

        .menu-asesor ul li a {
            text-decoration: none;
            color: #007bff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            transition: background-color 0.3s ease;
        }

        .menu-asesor ul li a:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
</html>