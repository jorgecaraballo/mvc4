<?php
class Logout {
	public function __construct() {
		session_start();
		session_unset(); // Limpiamos todas las variables de sesión. 
		session_destroy(); // Destruimos todas las sesiones. 
		header('location: '.base_url().'login');
		exit;
		}
	}
?>
