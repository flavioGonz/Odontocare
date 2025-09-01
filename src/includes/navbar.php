<?php
// Determina la página actual para el estado 'active' del menú
$currentPage = $_GET['page'] ?? 'inicio';
?>

<nav class="menu">
    <a href="index.php?page=inicio" class="link <?php echo ($currentPage == 'inicio') ? 'active' : ''; ?>">
        <span class="link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M213.38,109.62l-80-72.73a8,8,0,0,0-10.76,0l-80,72.73A8,8,0,0,0,40,115.54V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V115.54a8,8,0,0,0-2.62-5.92Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
        </span>
        <span class="link-title">Inicio</span>
    </a>
    <a href="index.php?page=pacientes" class="link <?php echo ($currentPage == 'pacientes') ? 'active' : ''; ?>">
        <span class="link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><circle cx="128" cy="96" r="64" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="16"></circle><path d="M30.99,216a112.04,112.04,0,0,1,194.02,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
        </span>
        <span class="link-title">Pacientes</span>
    </a>
    <a href="index.php?page=historial_clinico" class="link <?php echo ($currentPage == 'historial_clinico') ? 'active' : ''; ?>">
        <span class="link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M48,216a24,24,0,0,1,24-24H208a8,8,0,0,0,8-8V72a8,8,0,0,0-8-8H72A24,24,0,0,0,48,88V216Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><polyline points="48 216 48 40 176 40 216 72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline></svg>
        </span>
        <span class="link-title">Historial Clínico</span>
    </a>
    <a href="index.php?page=tratamientos" class="link <?php echo ($currentPage == 'tratamientos') ? 'active' : ''; ?>">
        <span class="link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M196.48,156.88a68,68,0,0,1-137,0c-11-23.77-16-43.2-15.89-53.79a76,76,0,0,1,152.78-1C194.27,112.55,199.19,134.4,196.48,156.88Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
        </span>
        <span class="link-title">Tratamientos</span>
    </a>
    <a href="index.php?page=configuracion" class="link <?php echo ($currentPage == 'configuracion') ? 'active' : ''; ?>">
        <span class="link-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M168,88a40,40,0,1,1-40-40A40,40,0,0,1,168,88Zm-8.49,89.51a88,88,0,1,1,19-19L219.31,199.31a8,8,0,0,1,0,11.32l-11.31,11.31a8,8,0,0,1-11.32,0Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
        </span>
        <span class="link-title">Configuración</span>
    </a>
</nav>