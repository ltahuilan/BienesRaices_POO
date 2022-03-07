<?php

    require '../../includes/app.php'; 

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    autenticado();

    //Importar la conexión
    $db = conectaDB();

    //Realizar el query
    $query = "SELECT * FROM vendedores"; 

    //Obtener los resultados
    $resultado = mysqli_query($db, $query);

    $errores = Propiedad::getErrores();

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $creado = '';
    $vendedorId = '';
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {

        //instanciar la clase
        $propiedad = new Propiedad($_POST);
        
        //obtner la conexion a la DB
        $db = conectaDB();

        //pasar la conexión hacia el metodo de clase
        $propiedad->setDB($db);

        /**ARCHIVOS */

        //Asignar archivo a la variable
        $imagen = $_FILES['imagen']['name'];        

        //generar nombre unico
        $nombreImg = uniqid(rand()) . $imagen;

        //pasar el nombre de la imagen hacia la clase (modelo)
        $propiedad->setImagen($nombreImg);
        
        //validacion
        $errores = $propiedad->validar();
        
        if(empty($errores)) { 

            
        //verificar si el directorio para almacenar imagenes existe
        if(!is_dir(DIR_IMAGENES)) {
            mkdir(DIR_IMAGENES);
        }

            //setear la imagen
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);

            //subir archivo
            $image->save( DIR_IMAGENES . $nombreImg);
            
            //Guardar en la BASE DE DATOS
            $resultado = $propiedad->guardar();
            
            if ($resultado) {
                /**query string: permite pasar cualquier tipo de valor por medio de la url */
                header('Location: /admin/index.php?resultado=1');
            }

        }
    }

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
                    <select name="vendedorId" >
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