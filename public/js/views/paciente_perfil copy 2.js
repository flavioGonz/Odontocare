// Version: 4.5
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const urlParams = new URLSearchParams(window.location.search);
    const pacienteId = urlParams.get('id');
    const historialTbody = document.getElementById('historial-tbody');
    const estudiosCard = document.getElementById('estudios-card');
    const estudiosBg = document.getElementById('estudios-bg');
    const placeholder = document.getElementById('slider-placeholder');

    function safeSetText(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    }

    function populateProfileInfo(info) {
        safeSetText('profile-nombre', `${info.nombre} ${info.apellido}`);
        safeSetText('profile-cedula', `Cédula: ${info.cedula}`);
        safeSetText('profile-edad', info.edad ? `${info.edad} años` : 'N/A');
        safeSetText('profile-email', info.email || 'N/A');
        safeSetText('profile-whatsapp', info.whatsapp || 'N/A');
        safeSetText('profile-ultima-consulta', info.ultima_consulta || 'N/A');
        safeSetText('profile-debe', `$${parseFloat(info.debe || 0).toFixed(2)}`);
        safeSetText('profile-haber', `$${parseFloat(info.haber || 0).toFixed(2)}`);
        const foto = document.getElementById('profile-foto');
        if (foto) foto.src = `images/avatars/${info.foto || 'default_avatar.png'}`;
    }

    function populateEstudios(estudios) {
        if (estudios && estudios.length > 0) {
            placeholder.style.display = 'none';
            // Mostrar el primer estudio como fondo
            let index = 0;
            estudiosBg.style.background = `url(images/estudios/${estudios[index].url_imagen}) center/cover no-repeat`;
            
            if (estudios.length > 1) {
                setInterval(() => {
                    index = (index + 1) % estudios.length;
                    estudiosBg.style.background = `url(images/estudios/${estudios[index].url_imagen}) center/cover no-repeat`;
                }, 4000);
            }
        } else {
            placeholder.style.display = 'block';
        }
    }

    function populateHistorialTable(historial) {
        historialTbody.innerHTML = '';
        if (historial.length === 0) {
            historialTbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 2rem;">No hay historial para mostrar.</td></tr>';
            return;
        }

        historial.forEach(cita => {
            const fila = document.createElement('tr');
            fila.dataset.citaId = cita.id;
            fila.setAttribute('tabindex', '0');
            fila.innerHTML = `
                <td><input type="date" value="${cita.fecha_cita || ''}" name="fecha_cita"></td>
                <td><input type="text" value="${cita.doctor_asignado || ''}" name="doctor_asignado"></td>
                <td><input type="text" value="${cita.diente_tratado || ''}" name="diente_tratado"></td>
                <td><input type="text" value="${cita.descripcion || ''}" name="descripcion"></td>
                <td><input type="number" step="0.01" value="${cita.debe || 0}" name="debe"></td>
                <td><input type="number" step="0.01" value="${cita.haber || 0}" name="haber"></td>
                <td class="col-acciones">
                    <div class="acciones-celda">
                        <button class="btn-accion btn-eliminar" title="Eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18M9 6v12m6-12v12M10 11h4" /></svg>
                        </button>
                    </div>
                </td>
            `;
            historialTbody.appendChild(fila);

            // Acción eliminar
            fila.querySelector('.btn-eliminar').addEventListener('click', () => {
                fila.remove(); // futuro: llamar API DELETE
            });
        });
    }

    async function cargarDatosPerfil() {
        try {
            const response = await fetch(`../api/pacientes/get_perfil.php?id=${pacienteId}`);
            if (!response.ok) throw new Error('Error en la respuesta del servidor');
            const result = await response.json();

            if (result.status === 'success') {
                populateProfileInfo(result.data.info);
                populateEstudios(result.data.estudios);
                populateHistorialTable(result.data.historial);
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error al cargar datos del perfil:', error);
            historialTbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding: 2rem; color: red;">No se pudieron cargar los datos del perfil.</td></tr>';
        }
    }

    cargarDatosPerfil();

    // --- Subir estudio ---
    const formSubir = document.getElementById('formSubirEstudio');
    const fileInput = document.getElementById('fileEstudio');
    if (formSubir && fileInput) {
        fileInput.addEventListener('change', async () => {
            const data = new FormData(formSubir);
            data.append('paciente_id', pacienteId);

            try {
                const resp = await fetch('../api/pacientes/upload_estudio.php', {
                    method: 'POST',
                    body: data
                });
                const res = await resp.json();
                if (res.status === 'success') {
                    alert('Estudio subido correctamente');
                    cargarDatosPerfil();
                } else {
                    alert('Error: ' + res.message);
                }
            } catch (e) {
                alert('Error subiendo estudio: ' + e.message);
            }
        });
    }
});
