<?php
// Version: 1.0
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

$data = json_decode(file_get_contents('php://input'), true);
$citaId = $data['cita_id'] ?? null;

if (!$citaId) {
    echo json_encode(['status' => 'error', 'message' => 'ID de cita inválido']);
    exit;
}

try {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT archivo FROM audios WHERE cita_id = ?");
    $stmt->execute([$citaId]);
    $audio = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($audio) {
        $filePath = __DIR__ . '/../../public/audio/consultas/' . $audio['archivo'];
        if (file_exists($filePath)) unlink($filePath);
        $db->prepare("DELETE FROM audios WHERE cita_id = ?")->execute([$citaId]);
    }

    echo json_encode(['status' => 'success', 'message' => 'Audio eliminado']);
} catch (PDOException $e) {
    error_log("Error en delete_audio.php: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
}
