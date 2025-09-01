<?php
// Version: 4.2
require_once __DIR__ . '/../core/database.php'; // Conexión a la BBDD

$pageTitle = 'Gestión de Pacientes';

// Obtenemos todos los pacientes de la base de datos
try {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT * FROM pacientes ORDER BY nombre ASC");
    $stmt->execute();
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $pacientes = [];
    echo "Error al cargar los pacientes: " . $e->getMessage();
}
?>

<main class="page-content">
    <div class="page-header">
        <h1>Gestión de Pacientes</h1>
        <button class="btn btn-primary" id="addNewRowBtn">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 256 256"><path d="M224,128a8,8,0,0,1-8,8H136v80a8,8,0,0,1-16,0V136H40a8,8,0,0,1,0-16h80V40a8,8,0,0,1,16,0v80h80A8,8,0,0,1,224,128Z"></path></svg>
            Agregar Paciente
        </button>
    </div>

    <div class="tabla-pacientes-contenedor" tabindex="0">
        <table class="tabla-pacientes" id="tablaPacientes">
            <thead>
                <tr>
                    <th class="col-foto">Foto</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Correo</th>
                    <th>WhatsApp</th>
                    <th>Última Consulta</th>
                    <th class="col-acciones">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pacientes as $paciente): ?>
                    <tr data-paciente-id="<?= htmlspecialchars($paciente['id']); ?>" tabindex="0">
                        <td class="col-foto">
                            <img src="images/avatars/<?= htmlspecialchars($paciente['foto'] ?: 'default_avatar.png'); ?>" alt="Foto de perfil">
                        </td>
                        <td><input type="text" value="<?= htmlspecialchars($paciente['nombre']); ?>" name="nombre"></td>
                        <td><input type="text" value="<?= htmlspecialchars($paciente['apellido']); ?>" name="apellido"></td>
                        <td><input type="text" value="<?= htmlspecialchars($paciente['cedula']); ?>" name="cedula"></td>
                        <td><input type="email" value="<?= htmlspecialchars($paciente['email']); ?>" name="email"></td>
                        <td><input type="tel" value="<?= htmlspecialchars($paciente['whatsapp']); ?>" name="whatsapp"></td>
                        <td><input type="date" value="<?= htmlspecialchars($paciente['ultima_consulta']); ?>" name="ultima_consulta"></td>
                        <td class="col-acciones">
                            <div class="acciones-celda">
                                <!-- Botón "Ver perfil" -->
                                <a href="index.php?page=paciente_perfil&id=<?= htmlspecialchars($paciente['id']); ?>" class="btn-accion btn-ver" title="Ver perfil completo">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </a>
                                <!-- Botón "Guardar cambios" -->
                                <button class="btn-accion btn-guardar" title="Guardar cambios">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                </button>
                                <!-- Botón "Eliminar paciente" -->
                                <button class="btn-accion btn-eliminar" title="Eliminar paciente">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.134-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.067-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
