<?php
class UsuariosModel extends Mysql {
    private $id;
    private $nombres;
    private $apellidos;
    private $email;
    private $password;
    private $rol_id;
    private $status_id;

    public function __construct() {
        parent::__construct();
    }

    // 1. Obtener todos los usuarios (con el nombre del rol)
    public function selectUsuarios() {
        $sql = "SELECT u.id, u.nombres, u.apellidos, u.email, u.rol_id, u.status_id, r.rol 
                FROM usuarios u 
                INNER JOIN roles r ON u.rol_id = r.id";
        $request = $this->select_all($sql, []);
        return $request;
    }

    // 2. Obtener un usuario por ID
    public function selectUsuario(int $id) {
        $this->id = $id;
        $sql = "SELECT id, nombres, apellidos, email, rol_id, status_id FROM usuarios WHERE id = ?";
        $request = $this->select($sql, [$this->id]);
        return $request;
    }

    // 3. Insertar un nuevo usuario (con SHA256 por ahora)
    public function insertUsuario(string $nombres, string $apellidos, string $email, string $password, int $rol_id, int $status_id) {
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->password = hash('SHA256', $password); // <-- Mantenemos SHA256
        $this->rol_id = $rol_id;
        $this->status_id = $status_id;

        $sql = "INSERT INTO usuarios (nombres, apellidos, email, password, rol_id, status_id) VALUES (?, ?, ?, ?, ?, ?)";
        $arrData = [$this->nombres, $this->apellidos, $this->email, $this->password, $this->rol_id, $this->status_id];
        $request = $this->insert($sql, $arrData);
        return $request;
    }

    // 4. Actualizar un usuario (sin cambiar la contraseña)
    public function updateUsuario(int $id, string $nombres, string $apellidos, string $email, int $rol_id, int $status_id) {
        $this->id = $id;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->rol_id = $rol_id;
        $this->status_id = $status_id;

        $sql = "UPDATE usuarios SET nombres = ?, apellidos = ?, email = ?, rol_id = ?, status_id = ? WHERE id = ?";
        $arrData = [$this->nombres, $this->apellidos, $this->email, $this->rol_id, $this->status_id, $this->id];
        $request = $this->update($sql, $arrData);
        return $request;
    }

    // 5. Eliminar un usuario
    public function deleteUsuario(int $id) {
        $this->id = $id;
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $request = $this->delete($sql, [$this->id]);
        return $request;
    }

    // 6. Obtener todos los roles (para el select del formulario)
    public function selectRoles() {
        $sql = "SELECT id, rol FROM roles WHERE status_id = 1";
        $request = $this->select_all($sql, []);
        return $request;
    }
}
?>
