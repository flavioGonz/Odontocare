<?php
// api/pacientes/delete.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método no permitido']);
    exit;
}

require_once __DIR__ . '/../../src/core/database.php';

$input = json_decode(file_get_contents('php://input'), true);

if (empty($input['id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No se proporcionó ID de paciente']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM pacientes WHERE id = ?");
    $stmt->execute([$input['id']]);

    echo json_encode(['status' => 'success', 'message' => 'Paciente eliminado con éxito']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el paciente: ' . $e->getMessage()]);
}
?>