<?php
class LoginModel extends Mysql { // Las propiedades son las de la tabla permisos
        private $id;
        private $email;
        private $password;
        private $token;
        public function __construct() {
            parent::__construct();
            }
        public function loginUser(string $email, string $password) {
            $this->email = $email;
            $this->password = $password;
            $query = "SELECT id, status_id FROM usuarios 
            WHERE email = ? AND password = ?";
            $request = $this->select($query, array($this->email, $this->password));
            return $request;
            }
        public function userData(int $id) { // id del usuario.
            $this->id = $id;
            $query = "SELECT 
            u.id,
            u.nombres,
            u.apellidos,
            u.email,
            u.fecha,
            u.token,
            u.rol_id,
            u.status_id,
            r.rol
            FROM usuarios u
            INNER JOIN roles r
            ON u.rol_id = r.id
            WHERE u.id = ?";
            $request = $this->select($query, array($this->id));
            return $request;
            }
    }
?>
