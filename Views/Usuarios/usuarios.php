<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Node 113 Admin</title>
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

    <!-- Menú lateral centralizado -->
    <?php require_once('Views/Templates/nav_admin.php'); ?>

    <main>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Gestión de Usuarios</h2>
            <button class="btn-submit" style="width: auto;" id="btnNuevoUsuario">Nuevo Usuario</button>
        </div>

        <!-- Formulario (oculto por defecto) -->
        <div class="card" id="formUsuarioContainer" style="display: none; margin-bottom: 20px;">
            <form id="formUsuario">
                <input type="hidden" id="usuario_id" name="id" value="0">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="usuario_nombres">Nombres</label>
                        <input type="text" id="usuario_nombres" name="nombres" required>
                    </div>
                    <div class="form-group">
                        <label for="usuario_apellidos">Apellidos</label>
                        <input type="text" id="usuario_apellidos" name="apellidos" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="usuario_email">Correo Electrónico</label>
                    <input type="email" id="usuario_email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="usuario_password">Contraseña (dejar en blanco para mantener la actual)</label>
                    <input type="password" id="usuario_password" name="password" placeholder="••••••••">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div class="form-group">
                        <label for="usuario_rol">Rol</label>
                        <select id="usuario_rol" name="rol_id" class="form-control" required>
                            <!-- Se llenará dinámicamente -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="usuario_status">Estado</label>
                        <select id="usuario_status" name="status_id" class="form-control">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Guardar</button>
                <button type="button" class="btn-login" id="btnCancelarUsuario" style="margin-top: 10px; width: 100%;">Cancelar</button>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        <div class="card">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <th style="padding: 10px;">ID</th>
                        <th style="padding: 10px;">Nombres</th>
                        <th style="padding: 10px;">Apellidos</th>
                        <th style="padding: 10px;">Email</th>
                        <th style="padding: 10px;">Rol</th>
                        <th style="padding: 10px;">Estado</th>
                        <th style="padding: 10px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyUsuarios">
                    <!-- Los usuarios se cargarán aquí vía JS -->
                </tbody>
            </table>
        </div>
    </main>

    <!-- Modal de Confirmación -->
    <dialog id="confirmDialog" class="custom-dialog">
        <div class="dialog-content">
            <h3 id="dialogTitle">Confirmar Acción</h3>
            <p id="dialogMessage">¿Estás seguro de que deseas eliminar este usuario?</p>
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
