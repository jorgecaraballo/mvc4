<?php
class PermisosModel extends Mysql {
    public function __construct() {
        parent::__construct();
    }

    // Obtiene todos los permisos de un rol
    public function permisosRol(int $rol_id) {
        $sql = "SELECT * FROM permisos WHERE rol_id = ?";
        $request = $this->select_all($sql, [$rol_id]);
        return $request;
    }
}
?>
