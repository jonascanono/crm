<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Buscar el usuario en la base de datos por correo
    $stmt = $conn->prepare("SELECT id, nombre, correo, contraseña, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña (¡Importante usar password_verify en un entorno real!)
        if ($contrasena == $row['contraseña']) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['usuario_nombre'] = $row['nombre'];
            $_SESSION['usuario_rol'] = $row['rol'];

            // Redirigir según el rol
            if ($row['rol'] == 'superusuario') {
                header("Location: ../admin/index.php"); // Creamos esta página luego
            } elseif ($row['rol'] == 'asesor') {
                header("Location: ../asesor/index.php"); // Creamos esta página luego
            } else {
                // Rol desconocido, cerrar sesión y mostrar error
                session_unset();
                session_destroy();
                $_SESSION['error_login'] = "Rol de usuario no reconocido.";
                header("Location: ../public/login.php");
            }
            exit();
        } else {
            $_SESSION['error_login'] = "Contraseña incorrecta.";
            header("Location: ../public/login.php");
        }
    } else {
        $_SESSION['error_login'] = "Correo electrónico no encontrado.";
        header("Location: ../public/login.php");
    }

    $stmt->close();
    $conn->close();
} else {
    // Si se intenta acceder a este script por GET, redirigir al formulario de login
    header("Location: ../public/login.php");
    exit();
}
?>