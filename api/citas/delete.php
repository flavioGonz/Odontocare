<?php
// Version: 4.4
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (empty($input['id'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No se proporcionó ID de registro']);
    exit;
}

// IMPORTANTE: Al eliminar un registro, también debemos REVERTIR el impacto financiero en el paciente.
$pdo->beginTransaction();
try {
    // 1. Obtener los valores de 'debe' y 'haber' del registro a eliminar
    $stmtGet = $pdo->prepare("SELECT paciente_id, debe, haber FROM citas WHERE id = ?");
    $stmtGet->execute([$input['id']]);
    $cita = $stmtGet->fetch(PDO::FETCH_ASSOC);

    if ($cita) {
        // 2. Actualizar el balance del paciente (restar lo que se va a eliminar)
        $stmtUpdate = $pdo->prepare("UPDATE pacientes SET debe = debe - ?, haber = haber - ? WHERE id = ?");
        $stmtUpdate->execute([$cita['debe'], $cita['haber'], $cita['paciente_id']]);
    }
    
    // 3. Eliminar el registro de la cita
    $stmtDelete = $pdo->prepare("DELETE FROM citas WHERE id = ?");
    $stmtDelete->execute([$input['id']]);

    $pdo->commit();
    echo json_encode(['status' => 'success', 'message' => 'Registro eliminado y balance actualizado']);

} catch (PDOException $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error al eliminar el registro: ' . $e->getMessage()]);
}
?>