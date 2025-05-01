<?php
session_start();

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'superusuario') {
    header("Location: ../../public/login.php");
    exit();
}

if (!isset($_GET['venta_id']) || !is_numeric($_GET['venta_id'])) {
    echo "ID de venta inválido.";
    exit();
}

$venta_id = $_GET['venta_id'];

// Aquí podrías opcionalmente consultar la base de datos para obtener información adicional sobre la venta
// por ejemplo, el ID del cliente o el nombre del asesor.

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Audio de Venta</title>
    <link rel="stylesheet" href="../../css/styles.css">
</head>
<body class="apple-style">
    <div class="upload-container">  <h2>Cargar Audio para la Venta ID: <?php echo $venta_id; ?></h2>
        <form action="subir_audio.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="venta_id" value="<?php echo $venta_id; ?>">
            <div>
                <label for="audio_file">Seleccionar archivo de audio:</label>
                <input type="file" id="audio_file" name="audio_file" accept="audio/*" required>
            </div>
            <div>
                <input type="submit" value="Subir Audio">
            </div>
        </form>
    </div>  
</body>
</html>