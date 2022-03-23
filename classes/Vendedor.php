<?php

namespace App;

class Vendedor extends ActiveRecord{

    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'email'] ?? '';
    protected static $tabla = 'vendedores';

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? NULL;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$errores[] = 'El nombre no puede estar vacío';
        }
        if(!$this->apellido) {
            self::$errores[] = 'El apellido no puede estar vacío';
        }
        if(!$this->telefono) {
            self::$errores[] = 'El apellido no puede estar vacío';
        }
        if(!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = 'Formato de teléfono no válido';
        }
        if(!$this->email) {
            self::$errores[] = 'El email no puede estar vacío';
        }
        if( !preg_match("/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/", $this->email) ) {
            self::$errores[] = 'Formato de email incorrecto';
        }

        return self::$errores;
    }

}


?>