<?php
// Version: 4.3.4
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

// Zona horaria por defecto
date_default_timezone_set('America/Caracas');

// Validar ID de paciente
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID de paciente inválido o no proporcionado']);
    exit;
}

try {
    // ✅ Ahora sí usamos la función correcta
    $db = getDatabaseConnection();

    // 1. Información principal del paciente (con edad calculada si existe fecha_nacimiento)
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

    // 2. Historial de citas
    $stmtCitas = $db->prepare("SELECT * FROM citas WHERE paciente_id = ? ORDER BY fecha_cita DESC");
    $stmtCitas->execute([$id]);
    $historial = $stmtCitas->fetchAll(PDO::FETCH_ASSOC);

    // 3. Estudios
    $stmtEstudios = $db->prepare("SELECT * FROM estudios WHERE paciente_id = ? ORDER BY fecha_estudio DESC");
    $stmtEstudios->execute([$id]);
    $estudios = $stmtEstudios->fetchAll(PDO::FETCH_ASSOC);

    // 4. Respuesta JSON
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
