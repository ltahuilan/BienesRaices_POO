<?php 

    require '../../includes/app.php';

    use App\Vendedor;

    autenticado();

    //crar una instancia vacía solo con la estructura de la clase
    $vendedor = new Vendedor;

    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //instanciar objeto y pasar los datos de $_POST
        $vendedor = new Vendedor($_POST);

        //validar los campos
        $errores = $vendedor->validar();

        if( empty($errores) ) {

            $resultado = $vendedor->guardar();

        }

    }

    incluirTemplates('header', $inicio = false, $admin = true);
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Crear Vendedor(a)</h1>

        <?php 
        /**inyectar HTML */
        foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error?>
        </div>
        <?php endforeach; ?>

        <a href="../index.php" class="boton boton-verde">&lt;&lt;Regresar</a>

        <form class="formulario" method="POST" action="/admin/vendedores/crear.php" enctype="multipart/form-data">
        <!--enctype="multipart/form-data" atributo que permite leer archivos, info visible desde superglobal $_FILES-->
            
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Guardar Vendedor" class="boton boton-verde">
        </form>
    </main>

<!--footer desde template php-->
<?php

incluirTemplates('footer');
?>
