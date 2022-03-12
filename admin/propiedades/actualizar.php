<?php
    require '../../includes/app.php';
    
    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    autenticado();

    //validar id de propiedad
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: /admin');
    }

    //consulta para obtener los registros de propiedades    
    $resultado = Propiedad::find($id, 'propiedades');

    $propiedad = $resultado;

    $errores = Propiedad::getErrores();
    
    if($_SERVER["REQUEST_METHOD"] == 'POST') {

        //sincronizar el objeto en memoria
        $resultado = $propiedad->sincronizar($_POST);

        //validar campos
        $errores = $propiedad->validar();

        //generar nombre de archivo
        $imagen = !$_FILES['imagen']['name'] ? '.jpg' : $_FILES['imagen']['name'];

        //generar nombre unico
        $nombreImg = uniqid(rand()) . $imagen;

        //Si exite un archivo en la super globla
        if ($_FILES['imagen']['name']){
            //setear la imagen
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);

            //pasar el nombre de la imagen hacia la clase (modelo)
            $propiedad->setImagen($nombreImg);
        }       
        
        if(empty($errores)) {

            $propiedad->guardar();
                            
            //subir archivo
            $image->save( DIR_IMAGENES . $nombreImg);
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

        <form class="formulario" method="POST" enctype="multipart/form-data">
        <!--enctype="multipart/form-data" atributo que permite leer archivos, info visible desde superglobal $_FILES-->

            <?php include '../../includes/templates/formulario.php'; ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>

    </main>

<!--footer desde template php-->
<?php
    
    incluirTemplates('footer');
?>