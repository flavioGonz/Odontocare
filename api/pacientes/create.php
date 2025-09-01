<?php
// api/pacientes/create.php

header('Content-Type: application/json');

// Solo permitir peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit;
}

require_once __DIR__ . '/../../src/core/database.php';

// Obtener los datos del cuerpo de la petición (enviados como JSON)
$input = json_decode(file_get_contents('php://input'), true);

// Validación simple (puedes hacerla más robusta)
if (empty($input['nombre']) || empty($input['apellido']) || empty($input['cedula'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Nombre, apellido y cédula son obligatorios']);
    exit;
}

$sql = "INSERT INTO pacientes (nombre, apellido, cedula, email, whatsapp) VALUES (?, ?, ?, ?, ?)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $input['nombre'],
        $input['apellido'],
        $input['cedula'],
        $input['email'] ?? null,
        $input['whatsapp'] ?? null
    ]);

    // Devolver una respuesta exitosa
    http_response_code(201); // Created
    echo json_encode(['status' => 'success', 'message' => 'Paciente creado con éxito']);

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    // Manejo de errores específicos, como cédula duplicada
    if ($e->getCode() == 23000) {
        echo json_encode(['status' => 'error', 'message' => 'La cédula ya existe']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al crear el paciente: ' . $e->getMessage()]);
    }
}
?>