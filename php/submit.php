<?php
include 'db.php';

$data = $_POST;
$required_fields = ['usuario', 'nombre', 'apellidos', 'direccion', 'telefono', 'nacionalidad', 'status_legal', 'fecha_nacimiento', 'cuenta', 'ruta', 'banco', 'identificacion', 'beneficiarios'];

foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        die(json_encode(['error' => 'Todos los campos son obligatorios']));
    }
}

$stmt = $conn->prepare("INSERT INTO ventas (usuario, nombre, apellidos, direccion, telefono, nacionalidad, status_legal, fecha_nacimiento, cuenta, ruta, banco, identificacion, beneficiarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssss", $data['usuario'], $data['nombre'], $data['apellidos'], $data['direccion'], $data['telefono'], $data['nacionalidad'], $data['status_legal'], $data['fecha_nacimiento'], $data['cuenta'], $data['ruta'], $data['banco'], $data['identificacion'], $data['beneficiarios']);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Error al guardar los datos']);
}
$stmt->close();
$conn->close();
?>