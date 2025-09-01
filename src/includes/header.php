<?php // Version: 3.3 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Clínica Odontológica'; ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
    <!-- (NUEVO) CSS de Splide.js -->
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="css/style.css">
    
    <?php
        $page = $_GET['page'] ?? 'inicio';
        $css_file = "css/views/{$page}.css";
        if (file_exists($css_file)) { echo "<link rel='stylesheet' href='{$css_file}'>"; }
    ?>
</head>
<body>
<!-- ... -->