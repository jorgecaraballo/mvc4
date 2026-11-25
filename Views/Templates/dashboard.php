<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - 113</title>
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
<body class="dashboard-body">

    <!-- AQUÍ SE CARGA EL MENÚ LATERAL -->
    <?php require_once('Views/Templates/nav_admin.php'); ?>

    <main>
        <h2>Resumen del Sistema</h2>
        <div class="cards-grid">
            <div class="card">
                <h3>CPU Load</h3>
                <p>1.24%</p>
            </div>
            <div class="card">
                <h3>Memoria Libre</h3>
                <p>4.2 GB</p>
            </div>
            <div class="card">
                <h3>Puerto Activo</h3>
                <p>8130</p>
            </div>
        </div>

<pre>
<?= var_export($_SESSION, true); ?>
</pre>

    </main>

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
    alert('No está definido page_name o controller.');
    </script>
    <?php endif; ?>

</body>
</html>
