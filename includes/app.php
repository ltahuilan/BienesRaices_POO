<?php

use App\ActiveRecord;

require 'funciones.php';
require 'config/database.php';
require __DIR__.'/../vendor/autoload.php';

//obtener la conexion a la base de datos --disponible en cualquier archivo al utilizar app.php
$db = conectaDB();

ActiveRecord::setDB($db);