<?php 

namespace App;

class ActiveRecord {

    //atributos estaticos
    protected static $db;
    // protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc','estacionamiento', 'creado', 'vendedorId'];
    protected static $columnasDB = [];
    protected static $tabla = '';
    protected static $errores = [];


    public function guardar() {

        if( !is_null($this->id) ) {
            return $this->actualizar();
        }else {
            return $this->crear();
        }
    }
    
    
    public function crear() {
        $atributos = $this->sanitizarDatos();
        
        /**Inserta valores en la DB */
        $query = "INSERT INTO " . static::$tabla . " (";
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
        
        $query = "UPDATE " . static::$tabla . " SET ";
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

        if( !is_null($this->id) ) {
            
            $this->eliminarImagen();

            //Elima el registro de la DB
            $query = "DELETE FROM " . static::$tabla . " WHERE id=". self::$db->escape_string($this->id);
            // debuguear($query);
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
        foreach(static::$columnasDB as $columna) {
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
        if( !is_null($this->id) ) {
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
        $errores = [];
        return self::$errores;
    }


    //método de clase para consultar todas los registros
    public static function all() {        
        $query = "SELECT * FROM " . static::$tabla; 
        return self::consultarSQL($query);
    }

    
    //método que consulta determinado número de registros
    public static function get($limite) {
        $query ="SELECT * FROM " . static::$tabla . " LIMIT " . $limite;
        return self::consultarSQL($query);
    }


    //método para consultar un registro en concreto
    public static function find($id) {
        $query = "SELECT * FROM ". static::$tabla . " WHERE id=${id}";
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
            $array[] = static::crearObjeto($registro); //El arreglo se llena con objetos
        }

        //liberar la memoria de datos
        $resultado->free();

        //retornar los resultados
        return $array;
    }


    /**crear objeto con los datos del array, verificar si la propiedad del objeto existe 
     * y mapea la propiedad del arreglo con la del objeto */
    protected static function crearObjeto($registro){
        $objeto = new static;
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