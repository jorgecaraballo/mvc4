<?php
class Dashboard extends Controllers { // Esta clase Controllers está en ../Libraries/Core/Controllers.php (el autoload la carga)
        public function __construct() {
            session_start();
            if (empty($_SESSION['login'])) {
                header('Location: '.base_url().'logout');
                exit;
                }
            parent::__construct();
            }
        public function dashboard() {

         if (!tienePermiso(1)) {
             header('Location: ' . base_url() . 'logout');
             exit;
         }

            $data['page_name'] = $this->getNombreMetodo();
            $data['controller'] = get_class($this);
            $data['css_files'] = ['dashboard.css'];
            $data['js_files'] = [
                'modelo.js',           // Framework base
                'vista.js',            // Framework base
                'controlador.js',      // Framework base
                $data['page_name'] . '/model.js',
                $data['page_name'] . '/view.js',
                $data['page_name'] . '/controller.js'
                ];

            $this->views->getView($this, $this->getNombreMetodo(), $data);
            }
    }
?>
