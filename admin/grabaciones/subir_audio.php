<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["venta_id"]) && is_numeric($_POST["venta_id"])) {
        $venta_id = $_POST["venta_id"];

        // Procesar la subida del archivo
        $upload_dir = "../../uploads/";
        // Asegúrate de que este directorio exista y tenga los permisos correctos
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Crea el directorio si no existe
        }
        $audio_file = $upload_dir . basename($_FILES["audio_file"]["name"]);

        // Validaciones (¡IMPORTANTE!)
        $file_type = strtolower(pathinfo($audio_file, PATHINFO_EXTENSION));

        if ($_FILES["audio_file"]["error"] == UPLOAD_ERR_OK) {
            if ($file_type != "mp3" && $file_type != "wav") {
                echo "Solo se permiten archivos MP3 y WAV.";
                exit();
            }

            // Mover el archivo subido
            if (move_uploaded_file($_FILES["audio_file"]["tmp_name"], $audio_file)) {
                // Actualizar la base de datos (¡PREVENIR INYECCIONES SQL!)
                include '../../php/db.php';
                $nombre_archivo = basename($_FILES["audio_file"]["name"]);
                $stmt = $conn->prepare("UPDATE clientes SET audio_path = ? WHERE id = ?");
                $stmt->bind_param("si", $nombre_archivo, $venta_id);

                if ($stmt->execute()) {
                    header("Location: listar_ventas.php");
                    exit();
                } else {
                    echo "Error al guardar la información en la base de datos.";
                }
                $stmt->close();
                $conn->close();

            } else {
                echo "Error al subir el archivo.";
            }

        } else {
            echo "Error al subir el archivo. Código de error: " . $_FILES["audio_file"]["error"];
        }

    } else {
        echo "ID de venta no válido.";
    }
}
?>