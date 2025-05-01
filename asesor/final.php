<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$_SESSION = array_merge($_SESSION, $_POST);

if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])) {
    $usuario = $_SESSION['usuario_id'];
} else {
    // Manejar el error:
    echo "Error: No se ha encontrado el usuario en la sesión.";
    exit; // O podrías redirigir a una página de error o lanzar una excepción.
}

include('../php/db.php');

$usuario = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];
$apellidos = $_SESSION['apellidos'];
$direccion = $_SESSION['direccion'];
$telefono = $_SESSION['telefono'];
$nacionalidad = $_SESSION['nacionalidad'];
$status_legal = $_SESSION['status_legal'];
$fecha_nacimiento = $_SESSION['fecha_nacimiento'];

$cuenta = $_SESSION['cuenta'];
$banco = $_SESSION['banco'];
$ruta = $_SESSION['ruta'];
$identificacion = $_SESSION['identificacion'];

$beneficiarios = $_POST['beneficiario_nombre'];
$relaciones = $_POST['beneficiario_relacion'];

$conn->begin_transaction();

try {
    // Insertar cliente
    $stmt = $conn->prepare("INSERT INTO clientes (usuario, nombre, apellidos, direccion, telefono, nacionalidad, status_legal, fecha_nacimiento, created_at, estado_venta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'pendiente')");
    $stmt->bind_param("ssssssss", $usuario, $nombre, $apellidos, $direccion, $telefono, $nacionalidad, $status_legal, $fecha_nacimiento);
    $stmt->execute();
    $cliente_id = $stmt->insert_id;
    $stmt->close();

    // Insertar datos bancarios
    $stmt = $conn->prepare("INSERT INTO cuentas_bancarias (cliente_id, cuenta, banco, ruta, identificacion) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $cliente_id, $cuenta, $banco, $ruta, $identificacion);
    $stmt->execute();
    $stmt->close();

    // Insertar beneficiarios
    $stmt = $conn->prepare("INSERT INTO beneficiarios (cliente_id, nombre, relacion) VALUES (?, ?, ?)");
    foreach ($beneficiarios as $index => $nombre_ben) {
        $relacion = $relaciones[$index];
        $stmt->bind_param("iss", $cliente_id, $nombre_ben, $relacion);
        $stmt->execute();
    }
    $stmt->close();

    $conn->commit();
    echo "<h2>✅ Datos guardados correctamente</h2>";
    echo '<button onclick="window.location.href=\'index.php\'">Volver al Inicio</button>';

} catch (Exception $e) {
    $conn->rollback();
    echo "<h2>❌ Error al guardar los datos: " . $e->getMessage() . "</h2>";
    echo '<p><a href="index.php">Volver al Inicio</a></p>';
}
?>