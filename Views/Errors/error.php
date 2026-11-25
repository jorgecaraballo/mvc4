<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - Node 113</title>
    <link rel="icon" type="image/svg+xml" href="favicon.svg">
    <!-- Reusamos exactamente el mismo CSS base -->
    <link rel="stylesheet" href="<?= media(); ?>css/styles.css">
    <style>
        /* Estilos específicos mínimos para la vista de error */
        body.error-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
            padding: 20px;
        }

        .error-card {
            max-width: 420px;
            width: 100%;
            padding: 40px;
        }

        .error-code {
            font-size: 5rem;
            font-weight: 800;
            color: var(--accent-color);
            margin: 0 0 10px 0;
            line-height: 1;
        }

        .error-card h2 {
            font-size: 1.25rem;
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .error-card p {
            font-size: 0.95rem;
            color: #94a3b8;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .btn-home {
            display: inline-block;
            padding: 11px 24px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.95rem;
            transition: opacity 0.2s;
        }

        .btn-home:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body class="error-body">

    <div class="card error-card">
        <h1 class="error-code">404</h1>
        <h2>Página no encontrada</h2>
        <p>Lo sentimos, la ruta que intentas consultar no existe o ha sido reubicada.</p>
        <a href="landing.html" class="btn-home">Volver al inicio</a>
    </div>

</body>
</html>
