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

        if($this->id) {
            return $this->actualizar();
        }else {
            return $this->crear();
        }
    }
    
    
    public function crear() {
        $atributos = $this->sanitizarDatos();
        
        /**Inserta valores en la DB */
        $query = "INSERT INTO propiedades (";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";
    
        $resultado = self::$db->query($query);
        if ($resultado) {
            /**query string: permite pasar cualquier tipo de valor por medio de la url */
            header('Location: /admin/index.php?resultado=1');
        }
    }


    public function actualizar() {

        $atributos = $this->sanitizarDatos();
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "${key}='${value}'";
        }
        
        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id='$this->id'";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado) {
            /**query string: permite pasar cualquier tipo de valor por medio de la url */
            header('Location: /admin/index.php?resultado=2');
        }
    }


    public function eliminar() {

        if($this->id) {
            
            $this->eliminarImagen();

            //Elima el registro de la DB
            $query = "DELETE FROM propiedades WHERE id=".$this->id;
            $resultado = self::$db->query($query);

            if ($resultado) {
                header('location: /admin?resultado=3');
            }
        }        
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
        $atributosSanitizados = [];
        foreach($atributos as $key => $value) {
            $atributosSanitizados[$key] = self::$db->escape_string($value);
        }        
        return $atributosSanitizados;
    }

    
    //asignar al atributo el nombre de la imagen
    public function setImagen($imagen) {
        //si hay un id presente
        if($this->id) {
            $this->eliminarImagen();
        }

        if($imagen) {
            $this->imagen = $imagen;
        }
    }


    //Elimina la imagen del disco duro
    public function eliminarImagen() {
        //verificar que exista una imagen con el nombre
        $existeArchivo = file_exists(DIR_IMAGENES.$this->imagen);
        //Si existe la image, eliminar
        if($existeArchivo) {
            unlink(DIR_IMAGENES . $this->imagen);
        };
    }


    //obtener arreglo de errores
    public static function getErrores() {
        return self::$errores;
    }


    //método de clase para consultar todas las propiedades
    public static function all($tabla) {        
        $query = "SELECT * FROM ${tabla}";
        return self::consultarSQL($query);
    }


    //método para consultar un registro en concreto
    public static function find($id, $tabla) {
        $query = "SELECT * FROM ${tabla} where id=${id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado); //array_shift devuielve el primer elemento de un array
    }


    //consultar SQL
    public static function consultarSQL($query) {

        //consultar la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro); //El arreglo se llena con objetos
        }

        //liberar la memoria de datos
        $resultado->free();

        //retornar los resultados
        return $array;
    }


    /**crear objeto con los datos del array, verificar si la propiedad del objeto existe 
     * y mapea la propiedad del arreglo con la del objeto */
    protected static function crearObjeto($registro){
        $objeto = new self;
        foreach($registro as $key => $value) {
            
            if(property_exists($objeto, $key)) {
                $objeto->$key = $value; // objecto["llave"] = "valor"
            }
        }
        return $objeto;
    }


    //Sincronizar objeto en memoria con POST
    public function sincronizar($args = []) {
        foreach($args as $key => $value) { 
            $this->$key = $value;
        }
        return $this;
    }
}

?>