<?php
// Version: 2.0
// public/index.php
session_start();

// 1. Cargar las piezas de la interfaz
require_once '../src/includes/header.php';
require_once '../src/includes/sidebar.php';

// 2. Determinar la página solicitada
$page = $_GET['page'] ?? 'inicio';

// 3. Lista blanca de TODAS las páginas permitidas en la aplicación
$allowed_pages = [
    // Menú principal
    'inicio', 
    'pacientes', 
    'paciente_perfil', // <-- AÑADIDO
    'citas', 
    'historial_clinico', 
    'estudios', 
    'tratamientos',
    'finanzas',
    'notificaciones', 
    'insumos',
    
    // Menú inferior
    'configuracion',
    'perfil'
];

// 4. Lógica de enrutamiento: mostrar la página correcta o un mensaje
if (in_array($page, $allowed_pages)) {
    
    $view_path = "../src/views/{$page}.php";

    if (file_exists($view_path)) {
        // Si el archivo de la vista existe, lo cargamos
        require_once $view_path;
    } else {
        // Si el archivo NO existe, pero la página está PERMITIDA,
        // mostramos un mensaje amigable "En construcción".
        $pageTitle = ucfirst(str_replace('_', ' ', $page)); // Reemplaza guiones bajos por espacios para el título
        echo "<main class='page-content'><h1>{$pageTitle}</h1><p>Esta sección se encuentra en construcción.</p></main>";
    }

} else {
    // Si la página solicitada NO está en la lista blanca, mostramos error 404
    require_once "../src/views/404.php";
}

// 5. Cargar el pie de página
require_once '../src/includes/footer.php';
?>