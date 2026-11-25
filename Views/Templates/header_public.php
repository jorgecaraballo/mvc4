<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Node 113</title>
    <link rel="icon" type="image/svg+xml" href="<?= media(); ?>favicon.svg">
    <!-- Reusamos exactamente el mismo CSS base -->
    <!-- El primer archivo que creamos para admin-panel fue el que actualmente corresponde con dashboard.html, y fue donde se definió originalmente style.css. Es por esta razón que el archivo base es ese, porque nació con el primer archivo que fue creado en admin-panel con Gemini (actualmente dashboard.html), y que nos satisfizo apenas vimos ese dashboard. Por esta razón style.css es el archivo css primigenio. -->
    <link rel="stylesheet" href="<?= media(); ?>css/styles.css">

    <!-- CSS específico por página -->
    <?php if (isset($data['css_files'])): ?>
        <?php foreach ($data['css_files'] as $css): ?>
<link rel="stylesheet" href="<?= media(); ?>css/<?= $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

</head>

<body class="landing-body">

    <!-- Cabecera pública -->
    <header class="landing-header">
        <a href="<?= base_url(); ?>" class="landing-logo">Node 113</a>
        <a href="<?= base_url(); ?>login" class="btn-login">Acceder</a>
    </header>

