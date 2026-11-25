<?php
class RolesModel extends Mysql {
    private $id;
    private $rol;
    private $descripcion;
    private $status_id;

    public function __construct() {
        parent::__construct();
    }

    // 1. Obtener todos los roles
    public function selectRoles() {
        $sql = "SELECT id, rol, descripcion, status_id FROM roles";
        $request = $this->select_all($sql, []); // <-- Añadimos el array vacío. En tu núcleo Libraries/Core/Mysql.php, el método select_all está definido para recibir dos parámetros obligatorios (la consulta y el array de valores)
        return $request;
    }

    // 2. Obtener un rol por ID
    public function selectRol(int $id) {
        $this->id = $id;
        $sql = "SELECT id, rol, descripcion, status_id FROM roles WHERE id = ?";
        $request = $this->select($sql, [$this->id]);
        return $request;
    }

    // 3. Insertar un nuevo rol
    public function insertRol(string $rol, string $descripcion, int $status_id) {
        $this->rol = $rol;
        $this->descripcion = $descripcion;
        $this->status_id = $status_id;
        
        $sql = "INSERT INTO roles (rol, descripcion, status_id) VALUES (?, ?, ?)";
        $arrData = [$this->rol, $this->descripcion, $this->status_id];
        $request = $this->insert($sql, $arrData);
        return $request; // Devuelve el ID insertado
    }

    // 4. Actualizar un rol
    public function updateRol(int $id, string $rol, string $descripcion, int $status_id) {
        $this->id = $id;
        $this->rol = $rol;
        $this->descripcion = $descripcion;
        $this->status_id = $status_id;

        $sql = "UPDATE roles SET rol = ?, descripcion = ?, status_id = ? WHERE id = ?";
        $arrData = [$this->rol, $this->descripcion, $this->status_id, $this->id];
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // 5. Eliminar un rol
    public function deleteRol(int $id) {
        $this->id = $id;
        $sql = "DELETE FROM roles WHERE id = ?";
        $request = $this->delete($sql, [$this->id]);
        return $request;
    }

    // Obtener todos los módulos y los permisos actuales de un rol
    public function selectModulosPermisos(int $rol_id) {
        // 1. Traemos todos los módulos
        $sqlModulos = "SELECT id, modulo FROM modulos WHERE status_id = 1";
        $modulos = $this->select_all($sqlModulos, []);

        // 2. Traemos los permisos de este rol
        $sqlPermisos = "SELECT modulo_id, r, w, u, d FROM permisos WHERE rol_id = ?";
        $permisosRol = $this->select_all($sqlPermisos, [$rol_id]);

        // 3. Cruzamos la información
        foreach ($modulos as $key => $modulo) {
            $modulos[$key]['r'] = 0;
            $modulos[$key]['w'] = 0;
            $modulos[$key]['u'] = 0;
            $modulos[$key]['d'] = 0;

            foreach ($permisosRol as $permiso) {
                if ($permiso['modulo_id'] == $modulo['id']) {
                    $modulos[$key]['r'] = $permiso['r'];
                    $modulos[$key]['w'] = $permiso['w'];
                    $modulos[$key]['u'] = $permiso['u'];
                    $modulos[$key]['d'] = $permiso['d'];
                    break;
                }
            }
        }
        return $modulos;
    }

    // Guardar los permisos de un rol
    public function updatePermisos(int $rol_id, array $permisos) {
        // Primero, borramos los permisos anteriores de este rol
        $sqlDelete = "DELETE FROM permisos WHERE rol_id = ?";
        $this->delete($sqlDelete, [$rol_id]);

        // Luego insertamos los nuevos
        $sqlInsert = "INSERT INTO permisos (rol_id, modulo_id, r, w, u, d) VALUES (?, ?, ?, ?, ?, ?)";
        foreach ($permisos as $p) {
            $arrData = [
                $rol_id,
                $p['modulo_id'],
                $p['r'],
                $p['w'],
                $p['u'],
                $p['d']
            ];
            $this->insert($sqlInsert, $arrData);
        }
        return true;
    }

}
?>
