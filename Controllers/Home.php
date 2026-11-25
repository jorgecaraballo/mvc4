<?php
class Home extends Controllers { // Esta clase Controllers está en ../Libraries/Core/Controllers.php (el autoload la carga)
    public function __construct() {
        parent::__construct();
        }
    public function home() {
        $data['page_title'] = 'página principal';
        $data['page_name'] = $this->getnombremetodo();
        $data['controller'] = get_class($this);
        $data['css_files'] = ['landing.css'];
        $data['js_files'] = [
            'modelo.js',           // framework base
            'vista.js',            // framework base
            'controlador.js',      // framework base
            $data['page_name'] . '/model.js',
            $data['page_name'] . '/view.js',
            $data['page_name'] . '/controller.js'
        ];
        $this->views->getview($this, $this->getnombremetodo(), $data);
        }
    }
?>
