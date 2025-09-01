<?php
// Version: 1.0
header('Content-Type: application/json');
require_once __DIR__ . '/../../src/core/database.php';

// Validar paciente_id
$pacienteId = filter_input(INPUT_POST, 'paciente_id', FILTER_VALIDATE_INT);
if (!$pacienteId) {
    echo json_encode(['status' => 'error', 'message' => 'ID de paciente inválido']);
    exit;
}

// Validar archivo
if (!isset($_FILES['estudio']) || $_FILES['estudio']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'No se recibió un archivo válido']);
    exit;
}

$allowedExtensions = ['jpg','jpeg','png','pdf'];
$uploadDir = __DIR__ . '/../../public/images/estudios/';

// Crear carpeta si no existe
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0775, true);
}

$fileName = $_FILES['estudio']['name'];
$fileTmp  = $_FILES['estudio']['tmp_name'];
$fileSize = $_FILES['estudio']['size'];
$fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

// Validar extensión
if (!in_array($fileExt, $allowedExtensions)) {
    echo json_encode(['status' => 'error', 'message' => 'Formato no permitido (solo JPG, PNG, PDF)']);
    exit;
}

// Validar tamaño (máx 10MB)
if ($fileSize > 10*1024*1024) {
    echo json_encode(['status' => 'error', 'message' => 'El archivo excede el tamaño máximo de 10MB']);
    exit;
}

// Generar nombre único
$newName = uniqid("estudio_") . "." . $fileExt;
$destino = $uploadDir . $newName;

// Mover archivo
if (!move_uploaded_file($fileTmp, $destino)) {
    echo json_encode(['status' => 'error', 'message' => 'Error al guardar el archivo en el servidor']);
    exit;
}

try {
    $db = getDatabaseConnection();

    $stmt = $db->prepare("INSERT INTO estudios (paciente_id, url_imagen, descripcion, fecha_estudio) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$pacienteId, $newName, "Estudio subido"]);

    echo json_encode(['status' => 'success', 'message' => 'Estudio subido correctamente']);
} catch (PDOException $e) {
    error_log("Error al subir estudio: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Error de base de datos']);
}
