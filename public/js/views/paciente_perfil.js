// Version: 5.5
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const pacienteId = new URLSearchParams(window.location.search).get('id');
    const historialTbody = document.getElementById('historial-tbody');
    const addCitaBtn = document.getElementById('addCitaBtn');
    const estudiosList = document.getElementById('estudios-list');
    const sliderPlaceholder = document.getElementById('slider-placeholder');
    const sliderContainer = document.getElementById('slider-estudios');

    let mediaRecorder;
    let audioChunks = [];

    // -------------------------------
    // Helpers de íconos
    // -------------------------------
    function micIcon() {
        return `<img src="images/rec.png" alt="Grabar" width="18">`;
    }
    function stopIcon() {
        return `<img src="images/stop.png" alt="Detener" width="18">`;
    }
    function playIcon() {
        return `<img src="images/play.png" alt="Play" width="14">`;
    }
    function saveIcon() {
        return `<img src="images/save.png" alt="Guardar" width="14">`;
    }
    function delIcon() {
        return `<img src="images/del.png" alt="Eliminar" width="14">`;
    }
    function micBtnHtml() {
        return `<button class="btn-accion btn-grabar-audio mic-btn" title="Grabar audio">${micIcon()}</button>`;
    }

    function safeSetText(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    }

    // -------------------------------
    // PERFIL
    // -------------------------------
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

    // -------------------------------
    // ESTUDIOS
    // -------------------------------
    function populateEstudios(estudios) {
        estudiosList.innerHTML = '';
        if (estudios && estudios.length > 0) {
            sliderPlaceholder.style.display = 'none';
            sliderContainer.style.display = 'block';

            estudios.forEach(e => {
                const li = document.createElement('li');
                li.className = "splide__slide";
                if (e.url_imagen.endsWith('.pdf')) {
                    li.innerHTML = `<embed src="images/estudios/${e.url_imagen}" type="application/pdf" width="100%" height="100%">`;
                } else {
                    li.innerHTML = `<img src="images/estudios/${e.url_imagen}" alt="${e.descripcion || 'Estudio'}" style="width:100%;height:100%;object-fit:cover;">`;
                }
                estudiosList.appendChild(li);
            });

            new Splide(sliderContainer, {
                type: 'loop',
                autoplay: true,
                interval: 4000,
                arrows: true,
                pagination: true,
                height: '300px'
            }).mount();
        } else {
            sliderContainer.style.display = 'none';
            sliderPlaceholder.style.display = 'block';
        }
    }

    // -------------------------------
    // HISTORIAL
    // -------------------------------
    function createHistorialRow(cita, isNew = false) {
        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td><input type="date" value="${cita.fecha_cita || ''}"></td>
            <td><input type="text" value="${cita.doctor_asignado || ''}" placeholder="Doctor"></td>
            <td><input type="text" value="${cita.diente_tratado || ''}" placeholder="Diente"></td>
            <td><input type="text" value="${cita.descripcion || ''}" placeholder="Descripción"></td>
            <td><input type="number" step="0.01" value="${cita.debe || 0}"></td>
            <td><input type="number" step="0.01" value="${cita.haber || 0}"></td>
            <td class="audio-cell">
                ${cita.audio ? `
                    <div class="audio-actions">
                        <button class="btn-accion btn-delete-audio" title="Eliminar audio">${delIcon()}</button>
                        <button class="btn-accion btn-play-audio" data-src="audio/consultas/${cita.audio}" title="Reproducir audio">${playIcon()}</button>
                        <span class="audio-duration"></span>
                    </div>
                ` : micBtnHtml()}
            </td>
            <td class="col-acciones">
                <button class="btn-accion btn-save" title="Guardar">${saveIcon()}</button>
                <button class="btn-accion btn-eliminar" title="Eliminar">${delIcon()}</button>
            </td>
        `;

        // -------------------------------
        // Guardar cita (insert/update)
        // -------------------------------
        fila.querySelector('.btn-save').addEventListener('click', async () => {
            const inputs = fila.querySelectorAll('input');
            const data = {
                id: cita.id || null,
                paciente_id: pacienteId,
                fecha_cita: inputs[0].value,
                doctor_asignado: inputs[1].value,
                diente_tratado: inputs[2].value,
                descripcion: inputs[3].value,
                debe: inputs[4].value,
                haber: inputs[5].value
            };

            const url = data.id ? '../api/pacientes/update_cita.php' : '../api/pacientes/add_cita.php';

            try {
                const resp = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data)
                });
                const result = await resp.json();
                if (result.status === 'success') {
                    alert(data.id ? 'Cita actualizada' : 'Cita agregada');
                    cargarDatosPerfil();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (err) {
                alert('Error al guardar cita: ' + err);
            }
        });

        // -------------------------------
        // Eliminar cita
        // -------------------------------
        fila.querySelector('.btn-eliminar').addEventListener('click', async () => {
            if (!cita.id) {
                fila.remove(); // no existe aún
                return;
            }
            try {
                const resp = await fetch('../api/pacientes/delete_cita.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: cita.id })
                });
                const result = await resp.json();
                if (result.status === 'success') {
                    fila.remove();
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (err) {
                alert('Error al eliminar cita: ' + err);
            }
        });

        // -------------------------------
        // Grabar audio
        // -------------------------------
        const btnAudio = fila.querySelector('.btn-grabar-audio');
        if (btnAudio) {
            btnAudio.addEventListener('click', async () => {
                if (btnAudio.dataset.recording === "true") {
                    mediaRecorder.stop();
                    btnAudio.innerHTML = micIcon();
                    btnAudio.dataset.recording = "false";
                } else {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        mediaRecorder = new MediaRecorder(stream);
                        audioChunks = [];
                        mediaRecorder.ondataavailable = e => audioChunks.push(e.data);
                        mediaRecorder.onstop = async () => {
                            const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                            const tempAudio = document.createElement('audio');
                            tempAudio.src = URL.createObjectURL(audioBlob);
                            await tempAudio.play().catch(()=>{});
                            tempAudio.pause();
                            const duration = isNaN(tempAudio.duration) ? "" : `${Math.round(tempAudio.duration)}s`;

                            const formData = new FormData();
                            formData.append('paciente_id', pacienteId);
                            formData.append('cita_id', cita.id);
                            formData.append('audio', audioBlob, `audio_${Date.now()}.webm`);

                            try {
                                const resp = await fetch('../api/pacientes/upload_audio.php', {
                                    method: 'POST',
                                    body: formData
                                });
                                const result = await resp.json();
                                if (result.status === 'success') {
                                    fila.querySelector('.audio-cell').innerHTML = `
                                        <div class="audio-actions">
                                            <button class="btn-accion btn-delete-audio" title="Eliminar audio">${delIcon()}</button>
                                            <button class="btn-accion btn-play-audio" data-src="audio/consultas/${result.file}" title="Reproducir audio">${playIcon()}</button>
                                            <span class="audio-duration">${duration}</span>
                                        </div>
                                    `;
                                } else {
                                    alert('Error: ' + result.message);
                                }
                            } catch (err) {
                                alert('Error al subir audio: ' + err);
                            }
                        };
                        mediaRecorder.start();
                        btnAudio.innerHTML = stopIcon();
                        btnAudio.dataset.recording = "true";
                    } catch (err) {
                        alert('No se pudo acceder al micrófono: ' + err);
                    }
                }
            });
        }

        // ▶️ Play / ⏹ Stop
        const btnPlay = fila.querySelector('.btn-play-audio');
        if (btnPlay) {
            let audio = new Audio(btnPlay.dataset.src);
            let isPlaying = false;
            btnPlay.addEventListener('click', () => {
                if (!isPlaying) {
                    audio.play();
                    btnPlay.innerHTML = stopIcon();
                    isPlaying = true;
                    audio.onended = () => {
                        btnPlay.innerHTML = playIcon();
                        isPlaying = false;
                    };
                } else {
                    audio.pause();
                    audio.currentTime = 0;
                    btnPlay.innerHTML = playIcon();
                    isPlaying = false;
                }
            });
        }

        // 🗑 Eliminar audio
        const btnDeleteAudio = fila.querySelector('.btn-delete-audio');
        if (btnDeleteAudio) {
            btnDeleteAudio.addEventListener('click', async () => {
                try {
                    const resp = await fetch('../api/pacientes/delete_audio.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ cita_id: cita.id })
                    });
                    const result = await resp.json();
                    if (result.status === 'success') {
                        fila.querySelector('.audio-cell').innerHTML = micBtnHtml();
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (err) {
                    alert('Error al eliminar audio: ' + err);
                }
            });
        }

        return fila;
    }

    function populateHistorialTable(historial) {
        historialTbody.innerHTML = '';
        if (historial.length === 0) {
            historialTbody.innerHTML = '<tr><td colspan="8" style="text-align:center; padding: 2rem;">No hay historial para mostrar.</td></tr>';
            return;
        }
        historial.forEach(cita => {
            const fila = createHistorialRow(cita);
            historialTbody.appendChild(fila);
        });
    }

    // -------------------------------
    // AGREGAR NUEVA CITA
    // -------------------------------
    if (addCitaBtn) {
        addCitaBtn.addEventListener('click', () => {
            const fila = createHistorialRow({}, true);
            historialTbody.prepend(fila);
        });
    }

    // -------------------------------
    // CARGAR PERFIL
    // -------------------------------
    async function cargarDatosPerfil() {
        try {
            const response = await fetch(`../api/pacientes/get_perfil.php?id=${pacienteId}`);
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
        }
    }

    cargarDatosPerfil();
});
