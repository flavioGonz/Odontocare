<?php
declare(strict_types=1);

// Sesión segura
session_set_cookie_params([
  'lifetime' => 0,
  'path'     => '/',
  'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
  'httponly' => true,
  'samesite' => 'Lax',
]);
session_start();

// Página actual
$page = $_GET['page'] ?? 'inicio';
$isLoginPage = ($page === 'login');

// CSRF
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Procesar POST (login)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isLoginPage) {
    require_once '../src/core/database.php';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $token    = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'], $token)) {
        $error = 'Token CSRF inválido';
    } else {
        $db = getDatabaseConnection();
        // 👇 Usamos la columna correcta: username
        $stmt = $db->prepare('SELECT * FROM usuarios WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!$user) {
            $error = 'Usuario no encontrado';
        } elseif ($user['bloqueado_hasta'] && strtotime($user['bloqueado_hasta']) > time()) {
            $error = 'Cuenta bloqueada. Intentá más tarde.';
        } elseif (!password_verify($password, $user['password_hash'])) {
            // Intentos fallidos
            $attempts = $user['intentos_fallidos'] + 1;
            $blockedUntil = null;
            if ($attempts >= 5) {
                $blockedUntil = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            }
            $update = $db->prepare('UPDATE usuarios SET intentos_fallidos = ?, bloqueado_hasta = ? WHERE id = ?');
            $update->execute([$attempts, $blockedUntil, $user['id']]);
            $error = 'Credenciales incorrectas';
        } else {
            // Login correcto
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['username']   = $user['username'];
            $update = $db->prepare('UPDATE usuarios SET intentos_fallidos = 0, bloqueado_hasta = NULL, ultimo_login = NOW() WHERE id = ?');
            $update->execute([$user['id']]);
            header('Location: index.php?page=inicio');
            exit;
        }
    }
}

// Proteger rutas
if (!$isLoginPage && !isset($_SESSION['usuario_id'])) {
    header('Location: index.php?page=login');
    exit;
}

// Layout
if (!$isLoginPage) {
    require_once '../src/includes/header.php';
    require_once '../src/includes/sidebar.php';
}

// Páginas permitidas (TODAS tus vistas actuales)
$allowed_pages = [
    'login', 'inicio', 'pacientes', 'paciente_perfil',
    'citas', 'historial_clinico', 'estudios', 'tratamientos', 'finanzas',
    'lista_precios', 'notificaciones', 'insumos',
    'configuracion', 'perfil'
];

if (in_array($page, $allowed_pages, true)) {
    $view_path = "../src/views/{$page}.php";
    if (file_exists($view_path)) {
        require_once $view_path;
    } else {
        http_response_code(404);
        require_once "../src/views/404.php";
    }
} else {
    http_response_code(404);
    require_once "../src/views/404.php";
}

if (!$isLoginPage) {
    require_once '../src/includes/footer.php';
}
