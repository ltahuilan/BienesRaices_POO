<?php 

namespace App;

class Propiedad extends ActiveRecord{

    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc','estacionamiento', 'creado', 'vendedorId'];
    protected static $tabla = 'propiedades';

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct ($args = []) {

        $this->id = $args['id'] ?? NULL;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? NULL;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }


    public function validar() {

        /**validar que los campos del formulario no estenvacíos */
        if(!$this->titulo) {
            self::$errores[] = 'El titulo no puede estar vacío';
        }

        if(!$this->precio) {
            self::$errores[] = 'Debes añadir un precio a la propiedad';
        }

        if(!$this->descripcion && strlen($this->descripcion) < 30) {
            self::$errores[] = 'Falta una descripción o debe tener al menos 30 caracteres';
        }

        if(!$this->habitaciones) {
            self::$errores[] = 'Indica el número de habitaciones';
        }

        if(!$this->wc) {
            self::$errores[] = 'Indica el número de baños';
        }

        if(!$this->estacionamiento) {
            self::$errores[] = 'Indica el número de estacionamientos';
        }

        //validar imagen
        if( is_null($this->imagen) ) {
            self::$errores[] = 'Selecciona una imagen';
        }

        //validar seleccion de un vendendor
        if(!$this->vendedorId) {
            self::$errores[] = 'Selecciona un vendedor';
        }

        return self::$errores;
    }

}

?>