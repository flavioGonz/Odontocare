<?php
$currentPage = $_GET['page'] ?? 'inicio';
?>

<ul class="sidebar-nav">
	<li>
		<a href="index.php?page=inicio" class="<?php echo ($currentPage == 'inicio') ? 'active' : ''; ?>">
			<svg xmlns="http://www.w.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M213.38,109.62l-80-72.73a8,8,0,0,0-10.76,0l-80,72.73A8,8,0,0,0,40,115.54V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V115.54a8,8,0,0,0-2.62-5.92Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
			<span>Inicio</span>
		</a>
	</li>
	<li>
		<a href="index.php?page=pacientes" class="<?php echo ($currentPage == 'pacientes') ? 'active' : ''; ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><circle cx="128" cy="96" r="64" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="16"></circle><path d="M30.99,216a112.04,112.04,0,0,1,194.02,0" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
			<span>Pacientes</span>
		</a>
	</li>
    <!-- ===== NUEVO ELEMENTO: CITAS ===== -->
    <li>
        <a href="index.php?page=citas" class="<?php echo ($currentPage == 'citas') ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><rect x="40" y="40" width="176" height="176" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></rect><line x1="176" y1="24" x2="176" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="80" y1="24" x2="80" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="40" y1="88" x2="216" y2="88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="128" y1="136" x2="128" y2="184" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line><line x1="152" y1="160" x2="104" y2="160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></line></svg>
            <span>Citas</span>
        </a>
    </li>
    <!-- ==================================== -->
	<li>
		<a href="index.php?page=historial_clinico" class="<?php echo ($currentPage == 'historial_clinico') ? 'active' : ''; ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M48,216a24,24,0,0,1,24-24H208a8,8,0,0,0,8-8V72a8,8,0,0,0-8-8H72A24,24,0,0,0,48,88V216Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><polyline points="48 216 48 40 176 40 216 72" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></polyline></svg>
			<span>Historial</span>
		</a>
	</li>
    <li>
		<a href="index.php?page=estudios" class="<?php echo ($currentPage == 'estudios') ? 'active' : ''; ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><rect x="32" y="48" width="192" height="160" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></rect><circle cx="88" cy="100" r="12"></circle><path d="M148,152l-22.3-33.4a8,8,0,0,0-13.4,0L64,192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><path d="M224,168l-40-56a8,8,0,0,0-13.4,0L136,160" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
			<span>Estudios</span>
		</a>
	</li>
    <li>
        <a href="index.php?page=tratamientos" class="<?php echo ($currentPage == 'tratamientos') ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M196.48,156.88a68,68,0,0,1-137,0c-11-23.77-16-43.2-15.89-53.79a76,76,0,0,1,152.78-1C194.27,112.55,199.19,134.4,196.48,156.88Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
            <span>Tratamientos</span>
        </a>
    </li>
    <li>
        <a href="index.php?page=finanzas" class="<?php echo ($currentPage == 'finanzas') ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M128,128h88a8,8,0,0,0,8-8V72a8,8,0,0,0-8-8H40a8,8,0,0,0-8,8v48a8,8,0,0,0,8,8h88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><path d="M32,128v64a8,8,0,0,0,8,8H216a8,8,0,0,0,8-8V128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path><circle cx="180" cy="164" r="12"></circle></svg>
            <span>Caja/Finanzas</span>
        </a>
    </li>
    <li>
        <a href="index.php?page=notificaciones" class="<?php echo ($currentPage == 'notificaciones') ? 'active' : ''; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.8,71.94A16,16,0,0,0,48,200H88.34a40,40,0,0,0,79.32,0H208a16,16,0,0,0,13.8-24.06Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path></svg>
            <span>Notificaciones</span>
        </a>
    </li>

    <!-- Separador -->
    <li class="menu-separator">	
		<a href="index.php?page=configuracion" class="<?php echo ($currentPage == 'configuracion') ? 'active' : ''; ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="192" height="192" fill="currentColor" viewBox="0 0 256 256"><path d="M164.45,108.32,120,85.67V36a8,8,0,0,0-16,0v49.67L59.55,108.32a8,8,0,0,0-4.08,10.61l48,83.13a8,8,0,0,0,13.84,0l48-83.13A8,8,0,0,0,164.45,108.32Z" opacity="0.2"></path><path d="M216,112H174.14l-42.06-72.86a8,8,0,0,0-13.84,0L76.18,112H40a8,8,0,0,0-6.92,4l-24,41.57A8,8,0,0,0,16,168H64v48a8,8,0,0,0,16,0V168h96v48a8,8,0,0,0,16,0V168h48a8,8,0,0,0,6.92-4l-24-41.57A8,8,0,0,0,216,112Zm-8,8-6.08,10.53L184,160H72l-17.9-31.47L48,120h42.14a8,8,0,0,0,6.92-4L128,60.83,158.94,116a8,8,0,0,0,6.92,4H208Z"></path></svg>
			<span>Ajustes</span>
		</a>
	</li>
    <li class="user-avatar">
        <a href="index.php?page=perfil">
            <img src="https://i.pravatar.cc/48?img=12" alt="Avatar del usuario">
            <span>Mi Perfil</span>
        </a>
    </li>
</ul>