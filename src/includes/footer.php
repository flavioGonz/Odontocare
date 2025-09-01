<?php // Version: 3.3 ?>
<!-- ... (HTML de las modales) ... -->

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
<!-- (NUEVO) Script de Splide.js -->
<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
<script src="js/main.js"></script>

<?php
    $page = $_GET['page'] ?? 'inicio';
    $js_file = "js/views/{$page}.js";
    if (file_exists($js_file)) { echo "<script src='{$js_file}'></script>"; }
?>
</body>
</html>