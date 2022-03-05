<?php

define('TEMPLATES_URL', __DIR__ .  '/templates');
define('FUNCIONES_URL', 'funciones.php');

function incluirTemplates (string $template, bool $inicio = false, bool $admin = false) {

    include TEMPLATES_URL . "/${template}.php";

};

function autenticado () {

    session_start();
    
    $auth = $_SESSION['login'];

    if ($auth) {
        return true;
    }

    return false;
};
