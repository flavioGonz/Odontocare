<?php 
// Version: 4.4
require_once __DIR__ . '/../core/database.php'; // Conexión a la BBDD

$paciente_id = $_GET['id'] ?? 0;
$pageTitle = "Perfil del Paciente"; 

$paciente = null;

if ($paciente_id) {
    try {
        $db = getDatabaseConnection();
        $stmt = $db->prepare("SELECT * FROM pacientes WHERE id = ? LIMIT 1");
        $stmt->execute([$paciente_id]);
        $paciente = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error al cargar el paciente: " . $e->getMessage();
    }
}
?>

<main class="page-content">
    <?php if ($paciente): ?>
        <div class="profile-header">
            <div class="avatar-container">
                <img id="profile-foto" 
                     src="images/avatars/<?= htmlspecialchars($paciente['foto'] ?: 'default_avatar.png'); ?>" 
                     alt="Foto del paciente">
            </div>
            <div class="info-container">
                <h1 id="profile-nombre">
                    <?= htmlspecialchars($paciente['nombre'] . " " . $paciente['apellido']); ?>
                </h1>
                <p id="profile-cedula"><?= htmlspecialchars($paciente['cedula']); ?></p>
            </div>
        </div>

        <div class="info-cards-grid">
            <!-- Tarjeta 1: Datos del Paciente -->
            <div class="info-card">
                <div class="wave"></div><div class="wave"></div><div class="wave"></div>
                <div class="card-content">
                    <h3>Datos del Paciente</h3>
                    <p class="profile-data-list">
                        <strong>Edad:</strong> <?= $paciente['fecha_nacimiento'] 
                            ? date_diff(date_create($paciente['fecha_nacimiento']), date_create('today'))->y . " años"
                            : 'N/D'; ?><br>
                        <strong>Correo:</strong> <?= htmlspecialchars($paciente['email']); ?><br>
                        <strong>WhatsApp:</strong> <?= htmlspecialchars($paciente['whatsapp']); ?><br>
                        <strong>Última Consulta:</strong> <?= htmlspecialchars($paciente['ultima_consulta']); ?>
                    </p>
                </div>
            </div>

            <!-- Tarjeta 2: Balance Financiero -->
            <div class="info-card">
                <div class="wave"></div><div class="wave"></div><div class="wave"></div>
                <div class="card-content">
                    <h3>Balance Financiero</h3>
                    <p class="balance-container">
                        <span class="balance-label">Debe:</span>
                        <span id="profile-debe" class="debe-text">$<?= number_format($paciente['debe'], 2); ?></span>
                        <span class="balance-label">Haber:</span>
                        <span id="profile-haber" class="haber-text">$<?= number_format($paciente['haber'], 2); ?></span>
                    </p>
                </div>
            </div>

            <!-- Tarjeta 3: Estudios -->
            <div class="info-card card-slider" id="estudios-card">
                <div class="wave"></div><div class="wave"></div><div class="wave"></div>
                <div class="card-content">
                    <h3>Estudios y Placas</h3>
                    <p id="slider-placeholder">No hay estudios registrados (aún).</p>
                </div>
            </div>

            <!-- Tarjeta 4: Acciones Rápidas -->
            <div class="info-card">
                <div class="wave"></div><div class="wave"></div><div class="wave"></div>
                <div class="card-content">
                    <h3>Acciones Rápidas</h3>
                    <div class="action-buttons-container">
                        <button class="btn-neumorphic" id="agendarCitaBtn" title="Agendar Nueva Cita">Cita</button>
                        <button class="btn-neumorphic" id="registrarPagoBtn" title="Registrar Pago">Pago</button>
                        <button class="btn-neumorphic" title="Subir Estudio">Estudio</button>
                        <button class="btn-neumorphic" title="Generar Reporte">Reporte</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historial -->
        <div class="historial-section">
            <h2>Historial de Tratamientos y Citas</h2>
            <div class="tabla-pacientes-contenedor" tabindex="0">
                <table class="tabla-pacientes" id="tablaHistorial">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Doctor</th>
                            <th>Diente</th>
                            <th>Descripción</th>
                            <th>Debe</th>
                            <th>Haber</th>
                            <th class="col-acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Podés cargar aquí dinámicamente el historial desde otra tabla (citas o tratamientos) -->
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <p>No se encontró el paciente solicitado.</p>
    <?php endif; ?>
</main>
