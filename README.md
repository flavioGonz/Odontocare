# 🦷 Sistema de Gestión para Clínica Dental

Proyecto web desarrollado en **PHP, MySQL, JS, HTML y CSS** para la gestión integral de una clínica odontológica.  
Incluye funcionalidades para manejo de pacientes, historial clínico, tratamientos, estudios, finanzas y control de insumos.  

---

## ✨ Características principales

- **Login seguro (Argon2ID)** para staff de la clínica.  
- **Gestión de pacientes** con foto de perfil, datos de contacto y consultas.  
- **Historial de Tratamientos y Citas**  
  - Agregar, editar y eliminar registros en vivo.  
  - Manejo de **balance financiero** (Debe / Haber).  
  - Adjuntar **audios** por cita (grabar en vivo, reproducir con botón ▶️, eliminar).  
- **Estudios y Placas**  
  - Subida de imágenes o PDFs.  
  - Visualización con **slider interactivo**.  
- **Notificaciones internas**.  
- **Configuración de la clínica**.  

---

## 📂 Estructura del proyecto

clinica_dental/
├── public/ # Carpeta pública (Front Controller)
│ ├── index.php # Enrutador principal
│ ├── css/ # Estilos
│ ├── js/ # Scripts frontend
│ ├── images/ # Logo, íconos, avatars
│ ├── audio/consultas/ # Audios asociados a citas
│ └── .htaccess # URLs amigables (Apache)
│
├── src/
│ ├── core/ # Núcleo de la app
│ │ ├── database.php # Conexión PDO a MySQL
│ │ └── functions.php # Funciones globales
│ │
│ ├── includes/ # Componentes comunes
│ │ ├── header.php
│ │ ├── footer.php
│ │ └── sidebar.php
│ │
│ └── views/ # Vistas principales
│ ├── inicio.php
│ ├── pacientes.php
│ ├── paciente_perfil.php
│ ├── tratamientos.php
│ ├── historial_clinico.php
│ ├── configuracion.php
│ └── 404.php
│
├── api/ # Endpoints AJAX (REST-like)
│ └── pacientes/
│ ├── get_perfil.php
│ ├── add_cita.php
│ ├── update_cita.php
│ ├── delete_cita.php
│ ├── upload_estudio.php
│ ├── upload_audio.php
│ └── delete_audio.php
│
└── config/
└── config.php # Credenciales y configuración

---

## ⚙️ Instalación y uso

1. Clonar el repositorio:  
   ```bash
   git clone https://github.com/tuusuario/clinica_dental.git
Copiar el proyecto a la carpeta de tu servidor local (ej. C:\xampp\htdocs\clinica).

Configurar la base de datos:

Importar el archivo SQL incluido (clinica_db.sql).

Ajustar credenciales en config/config.php.

Asegurarse de tener PHP ≥ 8.1 con soporte para argon2id.

(XAMPP 3.3.0 recomendado).

Iniciar el servidor y acceder en el navegador:


http://localhost/clinica/public/

🔑 Credenciales de ejemplo
Usuario: admin
Contraseña: admin
La contraseña está almacenada con hash Argon2ID por seguridad.

🎨 Capturas (ejemplos)
Login moderno con animaciones

Perfil de paciente con historial y slider de estudios

🛠️ Tecnologías usadas
Backend: PHP 8, MySQL, PDO

Frontend: HTML5, CSS3, JavaScript (ES6)

Animaciones: CSS3, Splide.js (slider)

Seguridad: Hash Argon2ID para contraseñas, rutas protegidas con sesiones

🚀 Roadmap
 Login staff con Argon2ID

 Gestión de pacientes

 Historial editable con audios adjuntos

 Estudios con slider

 Roles de usuario (admin, recepcionista, doctor)

 Dashboard de estadísticas

 Multi-idioma (ES/EN)

🤝 Contribución
¡Toda ayuda es bienvenida!

Haz un fork.

Crea una rama con tu feature:

bash
Copiar código
git checkout -b feature/nueva-funcionalidad
Commit de tus cambios:

bash
Copiar código
git commit -m "Agregada nueva funcionalidad"
Push a la rama:

bash
Copiar código
git push origin feature/nueva-funcionalidad
Abre un Pull Request.

📜 Licencia
Este proyecto se distribuye bajo licencia MIT.
Libre para uso personal y comercial con atribución.

👨‍💻 Autor
Flavio Gonzalez
Cofundador de Infratec Networks
Apasionado por la tecnología, redes y seguridad electrónica.

Vive en Uruguay.


---
