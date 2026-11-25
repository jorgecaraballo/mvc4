<?php
class Roles extends Controllers {
    public function __construct() {
         session_start();
         if (empty($_SESSION['login'])) {
             header('Location: '.base_url().'logout');
             exit;
             }
        parent::__construct();
        }

    public function roles() {

        if (!tienePermiso(2)) {
            header('Location: ' . base_url() . 'logout');
            exit;
        }

        $data['page_name'] = $this->getNombreMetodo();
        $data['controller'] = get_class($this);
        $data['css_files'] = ['roles.css']; // Lo crearemos luego
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

    // GET /roles/getRoles -> Devuelve todos los roles
    public function getRoles() {
        $arrData = $this->model->selectRoles();
        echo json_encode(['status' => true, 'data' => $arrData], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // POST /roles/setRol -> Inserta o Actualiza un rol
    public function setRol() {
        if ($_POST) {
            $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
            $rol = isset($_POST['rol']) ? trim($_POST['rol']) : '';
            $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
            $status_id = isset($_POST['status_id']) ? intval($_POST['status_id']) : 1;

            if (empty($rol)) {
                echo json_encode(['status' => false, 'msg' => 'El nombre del rol es obligatorio.'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            if ($id == 0) {
                // Insertar
                $request = $this->model->insertRol($rol, $descripcion, $status_id);
                $msg = 'Rol creado correctamente.';
            } else {
                // Actualizar
                $request = $this->model->updateRol($id, $rol, $descripcion, $status_id);
                $msg = 'Rol actualizado correctamente.';
            }

            echo json_encode(['status' => true, 'msg' => $msg, 'id' => $request], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // DELETE /roles/delRol -> Elimina un rol
    public function delRol() {
        if ($_POST) {
            $id = intval($_POST['id']);
            $request = $this->model->deleteRol($id);
            echo json_encode(['status' => true, 'msg' => 'Rol eliminado correctamente.'], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // GET /roles/getModulosPermisos/{id} -> Devuelve los módulos y permisos del rol
    public function getModulosPermisos($rol_id) {
        if (!tienePermiso(2)) {
            echo json_encode(['status' => false, 'msg' => 'Sin permiso']);
            exit;
        }
        
        $id = intval($rol_id);
        $modulos = $this->model->selectModulosPermisos($id);
        echo json_encode(['status' => true, 'data' => $modulos], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // POST /roles/setPermisos -> Guarda los permisos de un rol
    public function setPermisos() {
        if (!tienePermiso(2, 'w')) { // Suponiendo que 'w' es escribir/modificar
            echo json_encode(['status' => false, 'msg' => 'Sin permiso para modificar']);
            exit;
        }

        if ($_POST) {
            $rol_id = intval($_POST['rol_id']);
            $permisos = isset($_POST['permisos']) ? $_POST['permisos'] : [];

            // Sanitizar los datos (asegurar que sean enteros 0 o 1)
            $permisosSanitizados = [];
            foreach ($permisos as $p) {
                $permisosSanitizados[] = [
                    'modulo_id' => intval($p['modulo_id']),
                    'r' => intval($p['r']),
                    'w' => intval($p['w']),
                    'u' => intval($p['u']),
                    'd' => intval($p['d'])
                ];
            }

            $request = $this->model->updatePermisos($rol_id, $permisosSanitizados);

            if ($request) {
                echo json_encode(['status' => true, 'msg' => 'Permisos actualizados correctamente.'], JSON_UNESCAPED_UNICODE);
            } else {
                echo json_encode(['status' => false, 'msg' => 'Error al actualizar los permisos.'], JSON_UNESCAPED_UNICODE);
            }
            exit;
        }
    }

}
?>
