<?php
class Usuarios extends Controllers {
    public function __construct() {
         session_start();
         if (empty($_SESSION['login'])) {
             header('Location: '.base_url().'logout');
             exit;
             }
        parent::__construct();
        }

    public function usuarios() {
        // Verificar si el usuario tiene permiso de lectura para el módulo de Usuarios (ID 3)
        if (!tienePermiso(3)) {
            header('Location: ' . base_url() . 'dashboard');
            exit;
        }

        $data['page_name'] = $this->getNombreMetodo();
        $data['controller'] = get_class($this);
        $data['css_files'] = ['usuarios.css']; // Lo crearemos luego si hace falta
        $data['js_files'] = [
            'modelo.js',
            'vista.js',
            'controlador.js',
            $data['page_name'] . '/model.js',
            $data['page_name'] . '/view.js',
            $data['page_name'] . '/controller.js'
        ];
        $this->views->getView($this, $this->getNombreMetodo(), $data);
    }

    // --- API ENDPOINTS (AJAX) ---

    // GET /usuarios/getUsuarios -> Devuelve todos los usuarios
    public function getUsuarios() {
        $arrData = $this->model->selectUsuarios();
        echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // GET /usuarios/getRolesSelect -> Devuelve los roles para el select del formulario
    public function getRolesSelect() {
        $arrData = $this->model->selectRoles();
        echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // POST /usuarios/setUsuario -> Inserta o Actualiza un usuario
    public function setUsuario() {
        if ($_POST) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $nombres = isset($_POST['nombres']) ? trim($_POST['nombres']) : '';
            $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $rol_id = isset($_POST['rol_id']) ? intval($_POST['rol_id']) : 0;
            $status_id = isset($_POST['status_id']) ? intval($_POST['status_id']) : 1;

            // Validaciones básicas
            if (empty($nombres) || empty($apellidos) || empty($email) || $rol_id == 0) {
                echo json_encode(['status' => false, 'msg' => 'Todos los campos son obligatorios.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            if ($id == 0) {
                // Insertar nuevo usuario (requiere contraseña)
                if (empty($password)) {
                    echo json_encode(['status' => false, 'msg' => 'La contraseña es obligatoria para nuevos usuarios.'], JSON_UNESCAPED_UNICODE);
                    exit;
                }
                $request = $this->model->insertUsuario($nombres, $apellidos, $email, $password, $rol_id, $status_id);
                $msg = 'Usuario creado correctamente.';
            } else {
                // Actualizar usuario existente (la contraseña se ignora aquí, se actualizaría aparte)
                $request = $this->model->updateUsuario($id, $nombres, $apellidos, $email, $rol_id, $status_id);
                $msg = 'Usuario actualizado correctamente.';
            }

            echo json_encode(['status' => true, 'msg' => $msg, 'id' => $request], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // DELETE /usuarios/delUsuario -> Elimina un usuario
    public function delUsuario() {
        if ($_POST) {
            $id = intval($_POST['id']);
            $request = $this->model->deleteUsuario($id);
            echo json_encode(['status' => true, 'msg' => 'Usuario eliminado correctamente.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}
?>
