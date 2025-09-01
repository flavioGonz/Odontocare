<?php
// Version: 5.1
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

// Zona horaria
date_default_timezone_set('America/Caracas');

// Validar ID
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID de paciente inválido']);
    exit;
}

try {
    $db = getDatabaseConnection();

    // Info principal
    $stmtPaciente = $db->prepare("
        SELECT *,
               TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) AS edad
        FROM pacientes
        WHERE id = ?
    ");
    $stmtPaciente->execute([$id]);
    $paciente = $stmtPaciente->fetch(PDO::FETCH_ASSOC);

    if (!$paciente) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Paciente no encontrado']);
        exit;
    }

    // Historial de citas con audios
    $stmtCitas = $db->prepare("
        SELECT c.*,
               a.archivo AS audio
        FROM citas c
        LEFT JOIN audios a ON c.id = a.cita_id
        WHERE c.paciente_id = ?
        ORDER BY c.fecha_cita DESC
    ");
    $stmtCitas->execute([$id]);
    $historial = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);

    // Estudios
    $stmtEstudios = $db->prepare("SELECT * FROM estudios WHERE paciente_id = ? ORDER BY fecha_estudio DESC");
    $stmtEstudios->execute([$id]);
    $estudios = $stmtEstudios->fetchAll(PDO::FETCH_ASSOC);

    // Respuesta JSON
    echo json_encode([
        'status' => 'success',
        'data' => [
            'info' => $paciente,
            'historial' => $historial,
            'estudios' => $estudios
        ]
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("Error en get_perfil.php (ID $id): " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Error de base de datos al obtener el perfil del paciente.']);
}
