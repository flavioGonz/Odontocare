<?php 
// Version: 4.6
require_once __DIR__ . '/../core/database.php'; 
$paciente_id = $_GET['id'] ?? 0;
$pageTitle = "Perfil del Paciente"; 
?>
<main class="page-content">
    <div class="profile-header">
        <div class="avatar-container">
            <img id="profile-foto" src="images/avatars/default_avatar.png" alt="Foto del paciente">
        </div>
        <div class="info-container">
            <h1 id="profile-nombre">Cargando...</h1>
            <p id="profile-cedula"></p>
        </div>
    </div>

    <div class="info-cards-grid">
        <!-- Datos -->
        <div class="info-card">
            <div class="wave"></div><div class="wave"></div><div class="wave"></div>
            <div class="card-content">
                <h3>Datos del Paciente</h3>
                <p class="profile-data-list">
                    <strong>Edad:</strong> <span id="profile-edad"></span><br>
                    <strong>Correo:</strong> <span id="profile-email"></span><br>
                    <strong>WhatsApp:</strong> <span id="profile-whatsapp"></span><br>
                    <strong>Última Consulta:</strong> <span id="profile-ultima-consulta"></span>
                </p>
            </div>
        </div>

        <!-- Balance -->
        <div class="info-card">
            <div class="wave"></div><div class="wave"></div><div class="wave"></div>
            <div class="card-content">
                <h3>Balance Financiero</h3>
                <p class="balance-container">
                    <span class="balance-label">Debe:</span>
                    <span id="profile-debe" class="debe-text">$0.00</span>
                    <span class="balance-label">Haber:</span>
                    <span id="profile-haber" class="haber-text">$0.00</span>
                </p>
            </div>
        </div>
        
        <!-- Estudios con slider -->
        <div class="info-card card-slider" id="estudios-card">
            <div class="card-content">
                <h3>Estudios y Placas</h3>
                <div id="slider-estudios" class="splide">
                    <div class="splide__track">
                        <ul class="splide__list" id="estudios-list"></ul>
                    </div>
                </div>
                <p id="slider-placeholder">No hay estudios registrados.</p>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="info-card">
            <div class="wave"></div><div class="wave"></div><div class="wave"></div>
            <div class="card-content">
                <h3>Acciones Rápidas</h3>
                <div class="action-buttons-container">
                    <button class="btn-neumorphic" id="agendarCitaBtn">Cita</button>
                    <button class="btn-neumorphic" id="registrarPagoBtn">Pago</button>
                    
                    <form id="formSubirEstudio" enctype="multipart/form-data">
                        <label class="btn-neumorphic" for="fileEstudio">Subir Estudio</label>
                        <input type="file" id="fileEstudio" name="estudio" accept=".jpg,.jpeg,.png,.pdf" hidden>
                    </form>
                    
                    <button class="btn-neumorphic" id="generarReporteBtn">Reporte</button>
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
                <tbody id="historial-tbody"></tbody>
            </table>
        </div>
    </div>
</main>

<!-- Scripts Splide -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/css/splide.min.css">
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide/dist/js/splide.min.js"></script>
<script src="js/views/paciente_perfil.js"></script>
