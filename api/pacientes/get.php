<?php
// api/pacientes/get.php

header('Content-Type: application/json');

require_once __DIR__ . '/../../src/core/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No se proporcionó ID de paciente']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($paciente) {
        echo json_encode(['status' => 'success', 'data' => $paciente]);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['status' => 'error', 'message' => 'Paciente no encontrado']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error al obtener el paciente: ' . $e->getMessage()]);
}
?>