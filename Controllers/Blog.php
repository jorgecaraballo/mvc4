<?php
require_once('Controllers/Visitas.php');
class Blog extends Controllers {
    public function __construct() {
        parent::__construct();
    }

    // Este método recibe el slug desde la URL: /blog/ver/mi-articulo
    public function ver($slug = '') {
        // 1. Sanitizamos el slug
        $slug = strtolower(trim($slug));
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);

        if (empty($slug)) {
            header('Location: ' . base_url() . 'error');
            exit;
        }

        // 2. Armamos la ruta del archivo PHP
        $filePath = 'Views/Blog/posts/' . $slug . '.php'; // <-- CAMBIAMOS A .php

        // 3. Verificamos si el archivo existe
        if (!file_exists($filePath)) {
            require_once('Controllers/Error.php');
            return;
        }

        // 4. Leemos el contenido ejecutando el PHP (Output Buffering)
        ob_start();
        include $filePath;
        $htmlContent = ob_get_clean(); // <-- Aquí se captura el HTML final generado

        // 5. Preparamos los datos para la vista
        $data['page_name'] = 'ver';
        $data['controller'] = get_class($this);
        $data['slug'] = $slug;
        $data['html_content'] = $htmlContent;
        $data['css_files'] = ['blog.css'];

        // AÑADIMOS LOS SCRIPTS JS
        // El archivo de template ya carga modelo.js, vista.js y controlador.js base.
        // Aquí añadimos los específicos del blog.
        $data['js_files'] = [
            'modelo.js',           // Framework base
            'vista.js',            // Framework base
            'controlador.js',      // Framework base
            $data['page_name'] . '/model.js',
            $data['page_name'] . '/view.js',
            $data['page_name'] . '/controller.js'
            ];

        // 6. Cargamos la vista
        $this->views->getView($this, 'ver', $data);
        }
    }
?>
