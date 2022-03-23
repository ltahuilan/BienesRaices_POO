<?php

define('TEMPLATES_URL', __DIR__  .  '/templates');
define('FUNCIONES_URL', 'funciones.php');
define('DIR_IMAGENES', __DIR__ . '../../uploads/');

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {
    include TEMPLATES_URL . "/${template}.php";
};

function autenticado() {
    session_start();    
    if (!$_SESSION['login']) {
        header('location: /');
    }
};

function debuguear($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    exit;
}

function sntzr($html) : string {
    $string = htmlspecialchars($html);
    return $string;
}

//valida el tipo de entidad 
function validarTipo($tipo) {
    $tipos = ['vendedor', 'propiedad'];
    return in_array($tipo, $tipos);
}


//mostrar alertas
function mostrarAlerta($codigo) {
    $mensaje = '';

    switch($codigo) {
        case 1 :
            $mensaje = 'Registro creado con éxito';
            break;
        case 2 :
            $mensaje = 'Registro actualizado correctamente';
            break;
        case 3 :
            $mensaje = 'Registro eliminado correctamente';
            break;
        default:
            $mensaje = NULL;
    }

    return $mensaje;
}