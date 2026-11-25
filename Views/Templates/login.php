<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Node 113 Admin</title>
    <link rel="icon" type="image/svg+xml" href="<?= media(); ?>favicon.svg">
    <!-- Reusamos exactamente el mismo CSS del index -->
    <link rel="stylesheet" href="<?= media(); ?>css/styles.css">

    <!-- CSS específico por página -->
    <?php if (isset($data['css_files'])): ?>
        <?php foreach ($data['css_files'] as $css): ?>
<link rel="stylesheet" href="<?= media(); ?>css/<?= $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body class="login-body">

    <div class="card login-card">
        <h2>Node 113</h2>
        
        <login-component>
            <form action="#" method="POST">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="admin@node113.local" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-submit">Ingresar</button>
            </form>
        </login-component>

    </div>

    <!-- Scripts adicionales (cargados desde el controlador) -->
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

    <!-- Inicialización de la app -->
    <?php if (isset($data['page_name']) && isset($data['controller'])): ?>
    <script>
    window.addEventListener('load', function() {
        const app = new Controller(
            new Model(controller.toLowerCase(), page_name),
            new View(controller)
        );
    }, false);
    </script>
    <?php else: ?>
    <script>
    alert('No están definidos page_name o controller.');
    </script>
    <?php endif; ?>


</body>
</html>
