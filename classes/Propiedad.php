<?php 

namespace App;

class Propiedad {

    //atributos estaticos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc','estacionamiento', 'creado', 'vendedorId'];
    
    protected static $errores = [];
   
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

        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function validar() {

        /**validar que los campos del formulario no estenvacíos */
        if($this->titulo == '') {
            self::$errores[] = 'El titulo no puede estar vacío';
        }

        if($this->precio == '') {
            self::$errores[] = 'Debes añadir un precio a la propiedad';
        }

        if(strlen($this->descripcion) < 30) {
            self::$errores[] = 'Falta una descripción o debe tener al menos 30 caracteres';
        }

        if($this->habitaciones == '') {
            self::$errores[] = 'Indica el número de habitaciones';
        }

        if($this->wc == '') {
            self::$errores[] = 'Indica el número de baños';
        }

        if($this->estacionamiento == '') {
            self::$errores[] = 'Indica el número de estacionamientos';
        }

        //validar imagen
        if($this->imagen === '') {
            self::$errores[] = 'NO se ha seleccionado una imagen';
        }

        return self::$errores;
    }


    public function guardar() {

        $atributos = $this->sanitizarDatos();
        
        /**Inserta valores en la DB */
        $query = "INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);

        return $resultado;
    }


    //establecer la conexión a la base de datos
    public static function setDB($conexion) {
        self::$db = $conexion;
    }


    //mapea las columnas del arreglo $columnasDB con los atributos del objeto en memoria
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna; //$this contiene la referencia del objeto en memoria
        }
        return $atributos;
    }


    //sanitiza la entrada de datos
    public function sanitizarDatos() {
        $atributos = $this->atributos();
        $atribSanitizados = [];
        foreach($atributos as $key => $value) {
            $atribSanitizados[$key] = self::$db->escape_string($value);
        }        
        return $atribSanitizados;
    }

    
    //asignar al atributo el nombre de la imagen
    public function setImagen($imagen) {
        if($imagen) {
            $this->imagen = $imagen;
        }
    }


    //obtener arreglo de errores
    public static function getErrores() {
        return self::$errores;
    }


    public function mensaje($tipo, $mensaje) {

    }
}

?>