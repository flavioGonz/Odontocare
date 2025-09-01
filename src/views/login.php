<?php
// src/views/login.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Ingresar - Clínica Dental</title>
  <link rel="stylesheet" href="css/views/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="login-card">
    <div class="left-panel">
      <div class="icon-wrap"><i class="fa-solid fa-tooth"></i></div>
      <h2>Iniciar Sesión</h2>
      <form method="POST">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <div class="form-group">
          <label for="username">Usuario</label>
          <div class="input-icon">
            <i class="fa-solid fa-user"></i>
            <input id="username" type="text" name="username" required autofocus>
          </div>
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <div class="input-icon">
            <i class="fa-solid fa-lock"></i>
            <input id="password" type="password" name="password" required>
          </div>
        </div>
        <?php if (isset($error)): ?>
          <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <button type="submit">Ingresar</button>
      </form>
    </div>
    <div class="right-panel"></div>
  </div>
</body>
</html>
