<?php
// Version: 4.4
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id']) || empty($input['fecha_cita']) || empty($input['descripcion'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Faltan datos obligatorios']);
    exit;
}

// Aquí no actualizamos el balance total del paciente, ya que eso se maneja
// al crear el registro o al registrar un pago por separado. Solo editamos los datos de la cita.
$sql = "UPDATE citas SET fecha_cita = ?, doctor_asignado = ?, diente_tratado = ?, descripcion = ?, debe = ?, haber = ? WHERE id = ?";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $input['fecha_cita'],
        $input['doctor_asignado'] ?? 'N/A',
        $input['diente_tratado'] ?? null,
        $input['descripcion'],
        (float)($input['debe'] ?? 0.00),
        (float)($input['haber'] ?? 0.00),
        $input['id']
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Registro de historial actualizado']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el registro: ' . $e->getMessage()]);
}
?>