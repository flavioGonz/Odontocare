<?php
// api/pacientes/update.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit;
}

require_once __DIR__ . '/../../src/core/database.php';

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id']) || empty($input['nombre']) || empty($input['apellido']) || empty($input['cedula'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID, Nombre, apellido y cédula son obligatorios']);
    exit;
}

$sql = "UPDATE pacientes SET nombre = ?, apellido = ?, cedula = ?, email = ?, whatsapp = ? WHERE id = ?";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $input['nombre'],
        $input['apellido'],
        $input['cedula'],
        $input['email'] ?? null,
        $input['whatsapp'] ?? null,
        $input['id']
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Paciente actualizado con éxito']);

} catch (PDOException $e) {
    http_response_code(500);
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'La cédula ya existe en otro paciente']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al actualizar el paciente: ' . $e->getMessage()]);
    }
}
?>