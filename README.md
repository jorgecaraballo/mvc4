# mvc4 - Mini Framework MVC en Vainilla

Este es un framework MVC construido desde cero utilizando **PHP, HTML, CSS y JavaScript vainilla**. Nace como una refactorización de un sistema previo que dependía de frameworks pesados (Bootstrap, jQuery, SweetAlert), con el objetivo de eliminar dependencias y volver a los estándares web nativos.

## 🧘 Filosofía KISS

La arquitectura se rige por el principio **KISS** (Keep It Simple, Stupid):

- **Cero dependencias externas:** Sin Bootstrap, sin jQuery, sin FontAwesome. Todo es CSS Grid, Flexbox, Web Components y `<dialog>` nativo.
- **MVC puro:** Un backend en PHP vainilla y un frontend con un MVC nativo en JavaScript.
- **Código explícito:** No hay "magia" de terceros. Cada línea es auditable y mantenible a largo plazo.
- **Estándares web:** Uso de la API de validación nativa, Custom Elements y `XMLHttpRequest` (sin `fetch` aún, por compatibilidad).

## 🛠️ Características

- **Autenticación:** Login con validación de contraseña (SHA256) y sistema de sesiones.
- **Control de Acceso (RBAC):** Roles y permisos granulares (Lectura, Escritura, Actualización, Borrado) por módulo.
- **Módulos CRUD:** Gestión de Roles, Usuarios y Blog.
- **Blog:** Artículos estáticos con enrutamiento amigable (`/blog/ver/slug`), imágenes optimizadas en WebP y contador de visitas propio (SQLite).
- **Interfaz:** Tema oscuro, modales nativos (`<dialog>`), notificaciones tipo *toast* y menú lateral dinámico basado en permisos.

## 📋 Requisitos

- PHP 7.4 o superior (se recomienda 8.x).
- MariaDB o MySQL.
- Apache con `mod_rewrite` habilitado (o Nginx con la configuración equivalente).
- Extensión SQLite3 de PHP habilitada (para el contador de visitas del blog).

## 🚀 Instalación

1. **Clonar el repositorio:**

   ```bash
   git clone https://github.com/jorgecaraballo/mvc4.git
   cd mvc4
   ```

2. **Configurar las credenciales:**

   Copia el archivo de ejemplo y edítalo con tus datos de conexión:

   ```bash
   cp Config/Config.php.example Config/Config.php
   ```

   Edita `Config/Config.php` y define `BASE_URL`, `DB_HOST`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`.

3. **Importar la base de datos:**

   Crea una base de datos llamada `mvc4` e importa el archivo `mvc4.sql`:

   ```bash
   mysql -u root -p mvc4 < mvc4.sql
   ```

4. **Configurar Apache:**

   Asegúrate de que el `DocumentRoot` apunte a la carpeta del proyecto. El archivo `.htaccess` ya está incluido para el enrutamiento.

5. **Permisos de escritura:**

   Si vas a usar el contador de visitas del blog, asegúrate de que la carpeta `Storage` exista y tenga permisos de escritura para el usuario web:

   ```bash
   mkdir -p Storage/visitas
   chown -R www-data:www-data Storage
   chmod -R 775 Storage
   ```

## 🗂️ Estructura del Proyecto

- `Controllers/`: Controladores de la lógica de negocio.
- `Models/`: Modelos de acceso a datos.
- `Views/`: Vistas y templates (HTML).
- `Libraries/Core/`: El núcleo del mini-framework (Autoload, Router, DB).
- `Helpers/`: Funciones auxiliares (URLs, permisos, plantillas).
- `Assets/`: Recursos estáticos (CSS, JS, imágenes).
- `Config/`: Configuración del proyecto (credenciales ignoradas por Git).

## 📝 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT. Puedes usarlo, modificarlo y distribuirlo libremente.

---

Hecho con ❤️  por Jorge Caraballo.
