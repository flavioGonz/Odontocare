<?php 
// Version: 4.3.2
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
        <!-- Tarjeta 1: Datos del Paciente -->
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

        <!-- Tarjeta 2: Balance Financiero -->
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
        
        <!-- Tarjeta 3: Estudios con Slider -->
        <div class="info-card card-slider" id="estudios-card">
             <div class="wave"></div><div class="wave"></div><div class="wave"></div>
             <div class="card-content">
                <h3>Estudios y Placas</h3>
                <div id="image-slider" class="splide" aria-label="Galería de Estudios">
                    <div class="splide__track"><ul class="splide__list" id="estudios-list"></ul></div>
                </div>
                <p id="slider-placeholder">No hay estudios registrados.</p>
             </div>
        </div>

        <!-- Tarjeta 4: Acciones Rápidas -->
       <!-- Tarjeta 4: Acciones Rápidas (MODIFICADA) -->
        <div class="info-card">
            <div class="wave"></div><div class="wave"></div><div class="wave"></div>
            <div class="card-content">
                <h3>Acciones Rápidas</h3>
                <div class="action-buttons-container">
                    <button class="btn-neumorphic" id="agendarCitaBtn" title="Agendar Nueva Cita">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2c-5.523 0-10 4.477-10 10s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm4 11h-3v3h-2v-3H8v-2h3V8h2v3h3v2z"/></svg>
                        <span>Cita</span>
                    </button>
                    <button class="btn-neumorphic" id="registrarPagoBtn" title="Registrar Pago">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 20H3a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h18a1 1 0 0 1 1 1v6h-2V6H4v12h7v2zm8.414-3.586-2.535 2.535-1.415-1.414 2.536-2.535-2.536-2.535 1.415-1.414 2.535 2.535 2.535-2.535 1.415 1.414-2.536 2.535 2.536 2.535-1.415 1.414-2.535-2.535z"/></svg>
                        <span>Pago</span>
                    </button>
                    <button class="btn-neumorphic" title="Subir Estudio">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 15h2V9h3l-4-5-4 5h3v6zm-6 2h12v-2H5v2zm14-4h2v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-6h2v4h12v-4z"/></svg>
                        <span>Estudio</span>
                    </button>
                    <button class="btn-neumorphic" title="Generar Reporte">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M15 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V8l-6-4zM7 7h10v2H7V7zm10 6H7v2h10v-2zm-4 4H7v2h6v-2zm-1-8V5l4 4h-4z"/></svg>
                        <span>Reporte</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Nueva Tabla Editable de Historial -->
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
                <tbody id="historial-tbody">
                    <!-- Las filas se insertarán aquí dinámicamente con JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</main>