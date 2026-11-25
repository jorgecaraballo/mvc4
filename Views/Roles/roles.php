<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles - Node 113 Admin</title>
    <link rel="icon" type="image/svg+xml" href="<?= media(); ?>favicon.svg">
    <link rel="stylesheet" href="<?= media(); ?>css/styles.css">
    <link rel="stylesheet" href="<?= media(); ?>css/dashboard.css">

    <?php if (isset($data['css_files'])): ?>
        <?php foreach ($data['css_files'] as $css): ?>
<link rel="stylesheet" href="<?= media(); ?>css/<?= $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="dashboard-body">

    <!-- AQUÍ SE CARGA EL MENÚ LATERAL -->
    <?php require_once('Views/Templates/nav_admin.php'); ?>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Gestión de Roles</h2>
            <button class="btn-submit" style="width: auto;" id="btnNuevoRol">Nuevo Rol</button>
        </div>

        <!-- Formulario (oculto por defecto) -->
        <div class="card" id="formRolContainer" style="display: none; margin-bottom: 20px;">
            <form id="formRol">
                <input type="hidden" id="rol_id" name="id" value="0">
                <div class="form-group">
                    <label for="rol_nombre">Nombre del Rol</label>
                    <input type="text" id="rol_nombre" name="rol" required>
                </div>
                <div class="form-group">
                    <label for="rol_descripcion">Descripción</label>
                    <input type="text" id="rol_descripcion" name="descripcion">
                </div>
                <div class="form-group">
                    <label for="rol_status">Estado</label>
                    <select id="rol_status" name="status_id" class="form-control">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Guardar</button>
                <button type="button" class="btn-login" id="btnCancelar" style="margin-top: 10px; width: 100%;">Cancelar</button>
            </form>
        </div>

        <!-- Tabla de roles -->
        <div class="card">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Rol</th>
                        <th style="padding: 10px;">Descripción</th>
                        <th style="padding: 10px;">Estado</th>
                        <th style="padding: 10px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyRoles">
                    <!-- Los roles se cargarán aquí vía JS -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de Permisos -->
    <dialog id="permisosDialog" class="custom-dialog" style="max-width: 600px;">
        <div class="dialog-content">
            <h3 id="permisosTitle">Permisos del Rol</h3>
            <form id="formPermisos">
                <input type="hidden" id="permisos_rol_id" name="rol_id" value="0">
                <div id="modulosContainer" style="margin-bottom: 20px;">
                    <!-- Aquí se inyectarán los módulos vía JS -->
                </div>
                <div class="dialog-actions">
                    <button type="button" class="btn-login" id="permisosCancel">Cancelar</button>
                    <button type="submit" class="btn-submit">Guardar</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- Modal de Confirmación -->
    <dialog id="confirmDialog" class="custom-dialog">
        <div class="dialog-content">
            <h3 id="dialogTitle">Confirmar Acción</h3>
            <p id="dialogMessage">¿Estás seguro de que deseas eliminar este rol?</p>
            <div class="dialog-actions">
                <button type="button" class="btn-login" id="dialogCancel">Cancelar</button>
                <button type="button" class="btn-submit" id="dialogConfirm">Aceptar</button>
            </div>
        </div>
    </dialog>

    <!-- Contenedor para notificaciones -->
    <div id="toast-container"></div>

    <!-- Scripts adicionales -->
    <?php if (isset($data['js_files'])): ?>
        <?php foreach ($data['js_files'] as $js): ?>
            <script src="<?= media(); ?>js/<?= $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

    <script>
    'use strict';
    const base_url = "<?= base_url(); ?>";
    const page_name = "<?= $data['page_name'] ?? ''; ?>";
    const controller = "<?= $data['controller'] ?? ''; ?>";
    </script>

    <script>
    window.addEventListener('load', function() {
        const app = new Controller(
            new Model(controller.toLowerCase(), page_name),
            new View(controller)
        );
    }, false);
    </script>

</body>
</html>
