<?php

    require '../../includes/app.php';

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    autenticado();

    //instanciar la clase Propiedad para tener en memoria el modelo del objeto
    $propiedad = new Propiedad;

    //Importar la conexión
    $db = conectaDB();

    //Realizar el query
    $query = "SELECT * FROM vendedores";

    //Obtener los resultados
    $resultado = mysqli_query($db, $query);

    $errores = Propiedad::getErrores();
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {

        //instanciar la clase
        $propiedad = new Propiedad($_POST);

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

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
        <!--enctype="multipart/form-data" atributo que permite leer archivos, info visible desde superglobal $_FILES-->
            
            <?php include '../../includes/templates/formulario.php'; ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>