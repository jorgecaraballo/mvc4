<?php 
// PHPMailer
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function

/*
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
*/

// Load Composer's autoloader

/* 
require('Libraries/composer/vendor/autoload.php'); 
*/

// Retorna la url del proyecto
function base_url() {
	return BASE_URL;
	}
function media() {
	return BASE_URL."Assets/";
	}
function nodeModules() {
	return BASE_URL."Libraries/node_modules/";
	}
//Muestra información formateada
function dep($data) {
	$format  = print_r('<pre>');
	$format .= print_r($data);
	$format .= print_r('</pre>');
	return $format;
	}
function getPermisos() {
    // Verificamos si hay usuario en sesión
    if (isset($_SESSION['userData']) && isset($_SESSION['userData']['rol_id'])) {
        require_once('Models/PermisosModel.php');
        $objPermisos = new PermisosModel();
        $rol_id = $_SESSION['userData']['rol_id'];
        
        // Consultamos los permisos del rol
        $arrPermisos = $objPermisos->permisosRol($rol_id);
        
        $permisos = '';
        // Si hay permisos, los guardamos en sesión
        if (count($arrPermisos) > 0) {
            $permisos = $arrPermisos;
        }
        
        // Guardamos todos los permisos en la sesión
        $_SESSION['permisos'] = $permisos;
    } else {
        // Si no hay usuario en sesión, lo mandamos al login (o logout)
        header('Location: ' . base_url() . 'logout');
        exit;
    }
}

function tienePermiso(int $modulo_id, string $accion = 'r') {
    if (empty($_SESSION['permisos'])) return false;
    foreach ($_SESSION['permisos'] as $permiso) {
        if ($permiso['modulo_id'] == $modulo_id && $permiso[$accion] == 1) {
            return true;
        }
    }
    return false;
}

?>
