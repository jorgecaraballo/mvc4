<?php
// Cargar un partial/template
function load_template($template, $data = []) {
	// En PHP, extract($data); toma las claves del array asociativo $data y las convierte en variables, usando el nombre de cada clave como nombre de variable y su valor correspondiente como el valor de esa variable.
    extract($data);
    $template_path = "Views/Templates/{$template}.php";
    if (file_exists($template_path)) {
        include $template_path;
    } else {
        echo "Template no encontrado: {$template}";
    }
}
// Cargar partial
function load_partial($partial, $data = []) {
    extract($data);
    $partial_path = "Views/Partials/{$partial}.php";
    if (file_exists($partial_path)) {
        include $partial_path;
    }
}
// Determinar qué header/footer usar según el contexto
function get_header($type = 'public', $data = []) {
    return load_template("header_{$type}", $data);
}
function get_footer($type = 'public', $data = []) {
    return load_template("footer_{$type}", $data);
}
