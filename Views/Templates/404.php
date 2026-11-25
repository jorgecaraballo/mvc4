<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - Node 113</title>
    <link rel="icon" type="image/svg+xml" href="<?= media(); ?>favicon.svg">
    <!-- Reusamos exactamente el mismo CSS base -->
    <link rel="stylesheet" href="<?= media(); ?>css/styles.css">

    <!-- CSS específico por página -->
    <?php if (isset($data['css_files'])): ?>
        <?php foreach ($data['css_files'] as $css): ?>
<link rel="stylesheet" href="<?= media(); ?>css/<?= $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>
<body class="error-body">

    <div class="card error-card">
        <h1 class="error-code">404</h1>
        <h2>Página no encontrada</h2>
        <p>Lo sentimos, la ruta que intentas consultar no existe o ha sido reubicada.</p>
        <a href="<?= base_url(); ?>" class="btn-home">Volver al inicio</a>
    </div>

</body>
</html>
