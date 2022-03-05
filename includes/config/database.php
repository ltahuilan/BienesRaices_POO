<?php 

/**Conexion a la base de datos
 * se utiliza exit para que en caso de la conexion tenga error
 */

function conectaDB () : mysqli {
    $host = "localhost";
    $usr = 'root';
    $psw = 'root';
    $db_name = 'bienes_raices';

    $db = mysqli_connect($host, $usr, $psw, $db_name);

    mysqli_set_charset($db, "utf8");

    if(!$db) {
        echo 'conexion incorrecta';
        exit;
    }

    return $db;
};