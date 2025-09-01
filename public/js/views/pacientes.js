// Version: 4.1
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const tabla = document.getElementById('tablaPacientes');
    if (!tabla) return; 

    const tbody = tabla.querySelector('tbody');

    const manejarAccion = async (e) => {
        const boton = e.target.closest('.btn-accion');
        if (!boton) return;

        // Si el botón es un enlace (como el de ver perfil), no prevenimos su comportamiento
        if (boton.tagName === 'A') return;

        // Prevenimos el comportamiento por defecto solo para los botones
        e.preventDefault();

        const fila = boton.closest('tr');
        const pacienteId = fila.dataset.pacienteId;

        if (boton.classList.contains('btn-guardar')) {
            const inputs = fila.querySelectorAll('input');
            const datos = { id: pacienteId };
            inputs.forEach(input => {
                datos[input.name] = input.value;
            });
            const url = pacienteId ? '../api/pacientes/update.php' : '../api/pacientes/create.php';
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datos)
                });
                const result = await response.json();
                if (result.status === 'success') {
                    alert(result.message);
                    if (!pacienteId) window.location.reload();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al guardar:', error);
                alert('Error de conexión al guardar.');
            }
        }

        if (boton.classList.contains('btn-eliminar')) {
            if (!confirm('¿Estás seguro de que deseas eliminar a este paciente?')) {
                return;
            }
            if (!pacienteId) {
                fila.remove();
                return;
            }
            try {
                const response = await fetch('../api/pacientes/delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: pacienteId })
                });
                const result = await response.json();
                if (result.status === 'success') {
                    alert(result.message);
                    fila.remove();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error al eliminar:', error);
                alert('Error de conexión al eliminar.');
            }
        }
    };

    if (tbody) tbody.addEventListener('click', manejarAccion);

    const addNewRowBtn = document.getElementById('addNewRowBtn');
    if (addNewRowBtn) {
        addNewRowBtn.addEventListener('click', () => {
            const nuevaFila = document.createElement('tr');
            nuevaFila.setAttribute('tabindex', '0');
            // Plantilla de nueva fila actualizada con el botón de perfil deshabilitado
            nuevaFila.innerHTML = `
                <td class="col-foto"><img src="images/avatars/default_avatar.png" alt="Foto de perfil"></td>
                <td><input type="text" value="" name="nombre" placeholder="Nombre"></td>
                <td><input type="text" value="" name="apellido" placeholder="Apellido"></td>
                <td><input type="text" value="" name="cedula" placeholder="Cédula"></td>
                <td><input type="email" value="" name="email" placeholder="Correo"></td>
                <td><input type="tel" value="" name="whatsapp" placeholder="WhatsApp"></td>
                <td><input type="date" value="" name="ultima_consulta"></td>
                <td class="col-acciones">
                    <div class="acciones-celda">
                        <a class="btn-accion btn-ver" title="Guardar para ver perfil" style="opacity: 0.3; cursor: not-allowed;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </a>
                        <button class="btn-accion btn-guardar" title="Guardar nuevo paciente">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                        </button>
                        <button class="btn-accion btn-eliminar" title="Cancelar">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </td>
            `;
            tbody.prepend(nuevaFila);
            nuevaFila.focus();
            nuevaFila.querySelector('input[name="nombre"]').focus();
        });
    }
});