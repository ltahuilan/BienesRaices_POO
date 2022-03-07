<?php
    require '../../includes/app.php';

    autenticado();


    //validar id de propiedad
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }

    $db = conectaDB();
    // var_dump($db);

    //consulta para obtener los registros de propiedades
    $queryPropiedades = mysqli_query($db, "SELECT * FROM propiedades WHERE id = ${id}");
    $propiedad = mysqli_fetch_assoc($queryPropiedades);


   
    //consulta para obtener los registros de vendedores
    $queryVendedores = mysqli_query($db, "SELECT * FROM vendedores");

    $errores = [];

    $titulo = $propiedad['titulo'];
    $precio =  $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['wc'];
    $estacionamiento = $propiedad['estacionamiento'];
    $creado = $propiedad['creado'];
    $vendedorId = $propiedad['vendedorId'];
    $imagenPropiedad = $propiedad['imagen'];

    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {

        // echo "<pre>";
        // var_dump($_POST);
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
        $precio = mysqli_real_escape_string( $db, $_POST['precio'] );
        $descripcion = filter_var( mysqli_real_escape_string( $db, $_POST['descripcion'] ), FILTER_SANITIZE_STRING);
        $habitaciones = filter_var( mysqli_real_escape_string( $db, $_POST['habitaciones'] ), FILTER_SANITIZE_NUMBER_INT);
        $wc = filter_var( mysqli_real_escape_string( $db, $_POST['wc'] ), FILTER_SANITIZE_NUMBER_INT);
        $estacionamiento = filter_var( mysqli_real_escape_string( $db, $_POST['estacionamiento'] ), FILTER_SANITIZE_NUMBER_INT);
        $creado = date('Y/m/d');
        $vendedorId = mysqli_real_escape_string( $db, $_POST['vendedor']);

        /**Asignar archivo a la variable */
        $imagen = $_FILES['imagen'];

        // echo "<pre>";
        // var_dump($_FILES);
        // echo "</pre>";
        // exit;
        
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
        if(!$vendedorId) {
            $errores[] = 'Elige un vendedor';
        }
        
    
        /**validar tamaño de imagen */
        $size = 1024 * 1000; //1MB
        if ($imagen['size'] > $size) {
            $errores['err_img_size'] = 'La imagen no puede ser mayor a 1MB';
        }
        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";

        
        if(empty($errores)) {

            /**** ----SUBIR ARCHIVOS----- ****/

            // //Crear una carpeta
            $carpetaImagenes = '../../upload_img/';
    
            if (!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }


            //verificar que la imagen exista
            $nombreImg = '';

            if ($imagen['name']) {
                //elimina la imagen del repositorio
                unlink($carpetaImagenes . $imagenPropiedad);

                //generar nombre unico
                $nombreImg = uniqid(rand()) . $imagen['name'];
        
                //subir archivo
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImg);

            } else {

                $nombreImg = $imagenPropiedad;
            }           
    

            /**Inserta valores en la DB */
            $queryActualiza = "UPDATE propiedades SET 
                                        titulo = '${titulo}', 
                                        precio = ${precio},
                                        imagen = '${nombreImg}',
                                        descripcion = '${descripcion}', 
                                        habitaciones = ${habitaciones}, 
                                        wc = '${wc}', 
                                        estacionamiento = ${estacionamiento}, 
                                        vendedorId = ${vendedorId} WHERE id = ${id} ";
            /**DEBUG QUERY */
            // echo $queryActualiza;
            // exit;

            $resultado = mysqli_query($db, $queryActualiza);

            if($resultado) {
                /**query string: permite pasar cualquier tipo de valor por medio de la url */
                header('Location: /admin/index.php?resultado=2');
            }
        }
    }

    // include '../../includes/templates/header.php'; 
    incluirTemplates('header', $inicio = false, $admin = true);
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Propiedad</h1>

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

                <img src="/upload_img/<?php echo $imagenPropiedad ?>" alt="image-propiedad-thumb" class="imagen-thumb">

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
                        <option>-- Seleccionar --</option>

                        <?php while ($vendedor = mysqli_fetch_assoc($queryVendedores)) : ?>
                            <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : '' ?> value="<?php echo $vendedor['id']; ?>"><?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?></option>
                        <?php endwhile?>

                    </select>
                </div>
            </fieldset>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>