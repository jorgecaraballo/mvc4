<?php
class Errors extends Controllers { // Esta clase Controllers está en ../Libraries/Core/Controllers.php (el autoload la carga)
	public function __construct() {
		parent::__construct();
		}
	public function notFound() {
        $data['css_files'] = ['404.css'];
		$this->views->getView($this, '404', $data);
		}
	}
$notFound = new Errors();
$notFound->notFound();
?>
