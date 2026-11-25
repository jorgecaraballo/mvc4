<?php
require_once('Controllers/Visitas.php');
class Controllers {
	protected $model;
	protected $views;
	public function __construct() {
		$this->views = new Views();
		$this->loadModel(); // Cargamos el modelo del controlador, si existe. 
    // NUEVO: Iniciar sesión si no está iniciada
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // NUEVO: Cargar los permisos (esto solo actúa si hay un usuario logueado)
    // Si no hay usuario, getPermisos redirigirá al login.
    // Como ya estamos en Login, no entrará aquí, pero es importante.
    if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
        getPermisos();
    }
		}
	public function loadModel() { // Cargamos el modelo del controlador, si existe. 
		$model = get_class($this).'Model';
		$routClass = 'Models/'.$model.'.php';
		//echo '$routClass: <b>'.$routClass.'</b><br>';
		if (file_exists($routClass)) { // Solo si existe, lo requiere, e instancia un objeto. 
			require_once($routClass);
			$this->model = new $model();
			}
		}
  	public function getNombreMetodo() {
		// Usar debug_backtrace para obtener el nombre del método
		$trace = debug_backtrace(); // debug_backtrace(): Proporciona un array de información sobre la pila de llamadas.
		return $trace[1]['function']; // $trace[1] contiene el contexto donde se llamó. Accede al segundo elemento del array (donde se encuentra el método actual) y obtiene su nombre. Permite obtener el nombre del método actual en el contexto de una clase de manera efectiva y sencilla.
		}
    public function getVisitas($params) {
        $ob = new Visitas;
                if (strlen($params) > 0) {
                        $ob->fueraDelConstructor($params);
                        }
                else {
                        $ob->fueraDelConstructor(get_class($this));
                        }
        $ob->getVisitas();
        }
    public function postVisitas($params) {
        $ob = new Visitas;
                if (strlen($params) > 0) {
                        $ob->fueraDelConstructor($params);
                        }
                else {
                        $ob->fueraDelConstructor(get_class($this));
                        }
        $ob->postVisitas();
        }
	}
?>
