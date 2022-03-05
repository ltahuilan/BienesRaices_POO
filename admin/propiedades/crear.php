<?php

    require '../../includes/app.php'; 

    $auth = autenticado();

    if (!$auth) {
        header('location: /');
    }


    //Importar la conexión
    $db = conectaDB();
    // var_dump($db);

    // echo "<pre>";
    // var_dump($db);
    // echo "</pre>";
    // exit;

    //Realizar el query
    $query = "SELECT * FROM vendedores";

    //Obtener los resultados
    $resultado = mysqli_query($db, $query);

    $errores = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $creado = '';
    $vendedorId = '';
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {

        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";
        // exit;

        /**SANITIZAR ENTRADA DE DATOS */
        // $variable = 'correo@correo.com';
        // $var_sani = filter_var($variable, FILTER_SANITIZE_EMAIL);
        // var_dump($var_sani);

        /**mysqli_real_escape_string previene la inyección de codigo malicioso
         * por medio de un string.
         * filter_var($var, FILTER_SANITIZE...) sanitiza la entrada de datos.
         */
        $titulo = filter_var( mysqli_real_escape_string( $db, $_POST['titulo'] ), FILTER_SANITIZE_STRING);
        $precio = filter_var( mysqli_real_escape_string( $db, $_POST['precio'] ), FILTER_SANITIZE_NUMBER_INT);
        $descripcion = filter_var( mysqli_real_escape_string( $db, $_POST['descripcion'] ), FILTER_SANITIZE_STRING);
        $habitaciones = filter_var( mysqli_real_escape_string( $db, $_POST['habitaciones'] ), FILTER_SANITIZE_NUMBER_INT);
        $wc = filter_var( mysqli_real_escape_string( $db, $_POST['wc'] ), FILTER_SANITIZE_NUMBER_INT);
        $estacionamiento = filter_var( mysqli_real_escape_string( $db, $_POST['estacionamiento'] ), FILTER_SANITIZE_NUMBER_INT);
        $creado = date('Y/m/d');
        $vendedorId = filter_var( mysqli_real_escape_string( $db, $_POST['vendedor'] ), FILTER_SANITIZE_NUMBER_INT);

        /**Asignar archivo a la variable */
        $imagen = $_FILES['imagen'];

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";

        
        /**validar que los campos del formulario no estenvacíos */
        if($titulo == '') {
            $errores['err_titulo'] = 'El titulo no puede estar vacío';
        }
        if($precio == '') {
            $errores['err_precio'] = 'Debes añadir un precio a la propiedad';
        }
        if(strlen($descripcion) < 30) {
            $errores['err_descripcion'] = 'Falta una descripción o debe tener al menos 30 caracteres';
        }
        if($habitaciones == '') {
            $errores['err_habitaciones'] = 'Indica el número de habitaciones';
        }
        if($wc == '') {
            $errores['err_wc'] = 'Indica el número de baños';
        }
        if($estacionamiento == '') {
            $errores['err_estacionamiento'] = 'Indica el número de estacionamientos';
        }
        /**Validación de imagen */
        
        if(!$imagen['name']) {
            $errores['err_imagen'] = 'No se ha seleccionado una imagen';
        }
        /**validar por tamaño */
        $size = 1024 * 1000; //1MB
        if ($imagen['size'] > $size) {
            $errores['err_img_size'] = 'La imagen no puede ser mayor a 50KB';
        }
        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        /**----SUBIR ARCHIVOS----- */

        
        if(empty($errores)) {
            //Crear una carpeta
            $carpetaImagenes = '../../upload_img/';
    
            if (!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }
    
            //generar nombre unico
            $nombreImg = uniqid(rand()) . $imagen['name'];
    
            

            /**Inserta valores en la DB */
            $insert_propiedad = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedorId)
            VALUES ('$titulo', '$precio', '$nombreImg', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";

            $resultado = mysqli_query($db, $insert_propiedad);
            if($resultado) {
                //subir archivo
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImg);

                /**query string: permite pasar cualquier tipo de valor por medio de la url */
                header('Location: /admin/index.php?resultado=1');
            }
        }
    }

    // include '../../includes/templates/header.php';   
    incluirTemplates('header', $inicio = false, $admin = true);
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear</h1>

        <?php 
        /**inyectar HTML */
        foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>
        <?php endforeach; ?>

        <a href="../index.php" class="boton boton-verde">Regresar</a>

        <form
        class="formulario" method="POST" 
        action="/admin/propiedades/crear.php"
        enctype="multipart/form-data">
        <!--enctype="multipart/form-data" atributo que permite leer archivos, info visible desde superglobal $_FILES-->

            <fieldset>
                <legend>Imformación General</legend>

                <div class="grupo">
                    <label for="titulo">Titulo:</label>
                    <input 
                        type="text"
                        id="titulo"
                        name="titulo"
                        placeholder="Titulo de propiedad"
                        value="<?php echo $titulo?>">
                </div>

                <div class="grupo">
                    <label for="precio">Precio:</label>
                    <input
                        type="text"
                        id="precio"
                        name="precio"
                        placeholder="Precio de propiedad"
                        value="<?php echo $precio?>">                    
                </div>

                <div class="grupo">
                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">                    
                </div>
                <div class="grupo">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripcion de la propiedad"><?php echo $descripcion?></textarea>
                </div>

            </fieldset>

            <fieldset>
                <legend>Características</legend>

                <div class="grupo">
                    <label for="habitaciones">Número de Habitaciones:</label>
                    <input
                        type="number"
                        id="habitaciones"
                        name="habitaciones"
                        min="1" max="20"
                        placeholder="Ej.: 3"
                        value="<?php echo $habitaciones?>">
                </div>

                <div class="grupo">
                    <label for="wc">Número de Baños:</label>
                    <input
                        type="number"
                        id="wc"
                        name="wc"
                        min="1" max="20"
                        placeholder="Ej.: 3"
                        value="<?php echo $wc?>">
                </div>

                <div class="grupo">
                    <label for="estacionamiento">Número de Estacionamientos:</label>
                    <input
                        type="number"
                        id="estacionamiento"
                        name="estacionamiento"
                        min="0" max="20"
                        placeholder="A partir de 0"
                        value="<?php echo $estacionamiento?>">
                </div>
            </fieldset>

            <fieldset>
                <legend>Vendedores</legend>
                <div class="grupo">
                    <select name="vendedor" >
                        <option value="">-- Seleccionar --</option>

                        <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                            <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?> </option>
                        <?php endwhile?>

                    </select>
                </div>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>