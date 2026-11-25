<?php
class Login extends Controllers { // Esta clase Controllers está en ../Libraries/Core/Controllers.php (el autoload la carga)
        public function __construct() {
            session_start();
            if (isset($_SESSION['login'])) {
                if ($_SESSION['login']) {
                    header('Location: '.base_url().'dashboard');
                    exit;
                    }
                }
            parent::__construct();
            }
        public function login() {
                $data['page_name'] = $this->getNombreMetodo();
                $data['controller'] = get_class($this);
                $data['css_files'] = ['login.css'];
                $data['js_files'] = [
                    'modelo.js',           // Framework base
                    'vista.js',            // Framework base
                    'controlador.js',      // Framework base
                    $data['page_name'] . '/login-component.js',
                    $data['page_name'] . '/model.js',
                    $data['page_name'] . '/view.js',
                    $data['page_name'] . '/controller.js'
                    ];
                $this->views->getView($this, $this->getNombreMetodo(), $data);
                }
	public function loginUser() {
		if ($_POST) {
			if (empty($_POST['email']) || empty($_POST['password'])) {
				$arrResponse = array('status' => false, 'msg' => 'Error en los datos enviados.');
				}
			else {
                $email = strtolower($_POST['email']);
                $password = hash('SHA256', $_POST['password']);
                $requestUser = $this->model->loginUser($email, $password); // Array con id y status_id
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
                    }
                else {
                    $arrData = $requestUser; // Acá tenemos el id y el status_id del usuario, en un array asociativo. En JavaScript en frontend se interpreta como un objeto.
                    if ($arrData['status_id'] == 1) {
                        $_SESSION['id'] = $arrData['id'];
                        $_SESSION['login'] = true;
                        /* IMPORTANTE 
                         * Si no se define la variable $_SESSION['userData'] 
                         * entonces cuando la función getPermisos en Helpers.php caerá en el else, 
                         * entonces redireccionará a logout, destruirá la posible variable de sesión y las sesiones, 
                         * y luego redireccionará a login.
                         * Entonces, toda vez que no se defina la variable $_SESSION['userData'], 
                         * caeremos siempre en login cuando se intente iniciar sesión. 
                         * Típicamente esto puede ocurrir si el rol_id del usuario (tabla usuarios) no coincide 
                         * con el id del rol (tabla roles) */
                        $_SESSION['userData'] = $this->model->userData($arrData['id']); // Lo que nos devuelve, es un array asociativo.
				        $arrResponse = array('status' => true, 'msg' => 'OK', 'data' => $arrData, '$_SESSION' => $_SESSION);
                        }
                    else {
				        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.', 'data' => $arrData);
                        }
                    }
				}
			}
        else {
				$arrResponse = array('status' => false, 'msg' => 'No existe $_POST');
                }
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		exit;
		}
    }
?>
