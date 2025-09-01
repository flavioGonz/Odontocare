clinica_dental/
├── public/
│   ├── index.php             <-- PUNTO DE ENTRADA ÚNICO (Front Controller)
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── main.js
│   ├── images/
│   │   ├── logo.png
│   │   └── avatars/
│   └── .htaccess             <-- Para URLs amigables (opcional pero recomendado)
│
├── src/
│   ├── core/
│   │   ├── database.php      <-- Lógica de conexión a la BBDD
│   │   └── functions.php     <-- Funciones globales (ej. sanitizar datos)
│   │
│   ├── includes/
│   │   ├── header.php        <-- Parte superior del HTML (doctype, head, inicio body)
│   │   ├── footer.php        <-- Parte inferior del HTML (scripts, cierre body/html)
│   │   └── sidebar.php       <-- El menú de navegación que creamos
│   │
│   └── views/
│       ├── inicio.php
│       ├── pacientes.php
│       ├── historial_clinico.php
│       ├── tratamientos.php
│       ├── lista_precios.php
│       ├── notificaciones.php
│       ├── insumos.php
│       ├── configuracion.php
│       └── 404.php           <-- Página para errores
│
└── config/
    └── config.php            <-- Credenciales de BBDD, claves API, etc.


Explicación Detallada de Cada Parte
1. Carpeta Raíz (clinica_dental/)
Es la carpeta principal que contiene todo tu proyecto. No se expone directamente a la web.

2. public/
Esta es la única carpeta que debe ser accesible desde el navegador. Tu servidor web (Apache, Nginx) debe apuntar aquí. Esto es crucial para la seguridad, ya que evita que los usuarios accedan a archivos sensibles como tu configuración de base de datos.
index.php: Este es el Front Controller. Todas las peticiones de los usuarios llegarán a este archivo. Su trabajo es cargar la configuración, iniciar la sesión y, basándose en la URL, decidir qué "vista" mostrar desde la carpeta src/views/.
css/, js/, images/: Carpetas para tus "assets" estáticos. El navegador necesita acceder a ellos para renderizar la página correctamente.
.htaccess: (Para servidores Apache). Permite crear URLs amigables, por ejemplo, que www.tuclinica.com/pacientes internamente cargue index.php?page=pacientes.

3. src/ (Source o Código Fuente)
El "cerebro" de tu aplicación. Esta carpeta no es accesible públicamente.
core/: Contiene la lógica principal y fundamental de la app.
database.php: Un archivo que gestiona la conexión a tu base de datos (MySQL, PostgreSQL, etc.).
functions.php: Funciones de ayuda que usarás en todo el proyecto (ej: isLoggedIn(), formatDate(), etc.).
includes/: Piezas de la interfaz que se repiten en casi todas las páginas.
header.php: Incluye el <head>, el título de la página y el inicio del <body>.
sidebar.php: El código de la barra de navegación lateral que creamos.
footer.php: Cierra las etiquetas principales e incluye los archivos JavaScript antes de </body>.
views/: El contenido específico de cada página. Son plantillas que se "incrustan" dentro de la estructura principal definida por header.php y footer.php. Por ejemplo, pacientes.php contendrá la tabla y el formulario para gestionar pacientes.

4. config/
Contiene los archivos de configuración. Al estar fuera de la carpeta public/, es inaccesible desde el navegador, lo cual es vital para la seguridad.
config.php: Aquí defines constantes con tus credenciales de base de datos, claves de API, y otras configuraciones del entorno.
