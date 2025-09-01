<?php
// Version: 1.2
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

$pacienteId = filter_input(INPUT_POST, 'paciente_id', FILTER_VALIDATE_INT);
$citaId = filter_input(INPUT_POST, 'cita_id', FILTER_VALIDATE_INT);

if (!$pacienteId) {
    echo json_encode(['status' => 'error', 'message' => 'ID de paciente inválido']);
    exit;
}
if (!$citaId) {
    echo json_encode(['status' => 'error', 'message' => 'ID de cita inválido']);
    exit;
}

if (!isset($_FILES['audio']) || $_FILES['audio']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'No se recibió audio válido']);
    exit;
}

$uploadDir = __DIR__ . '/../../public/audio/consultas/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);

$newName = uniqid("audio_") . ".webm";
$destino = $uploadDir . $newName;

if (!move_uploaded_file($_FILES['audio']['tmp_name'], $destino)) {
    echo json_encode(['status' => 'error', 'message' => 'Error al guardar audio']);
    exit;
}

try {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("INSERT INTO audios (paciente_id, cita_id, archivo, fecha_subida) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$pacienteId, $citaId, $newName]);

    echo json_encode(['status' => 'success', 'file' => $newName]);
} catch (PDOException $e) {
    error_log("Error en upload_audio.php: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
}
