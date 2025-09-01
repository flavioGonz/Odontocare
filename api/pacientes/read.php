<?php
// api/pacientes/read.php

header('Content-Type: application/json');

// La ruta correcta para encontrar el archivo de conexión
require_once __DIR__ . '/../../src/core/database.php';

try {
    $stmt = $pdo->prepare("SELECT id, foto, nombre, apellido, cedula, email, whatsapp, debe, haber, ultima_consulta FROM pacientes ORDER BY nombre ASC");
    $stmt->execute();
    
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'status' => 'success',
        'data' => $pacientes
    ]);
    
} catch (PDOException $e) {
    http_response_code(500); 
    echo json_encode([
        'status' => 'error',
        'message' => 'Error al obtener los pacientes: ' . $e->getMessage()
    ]);
}
?>