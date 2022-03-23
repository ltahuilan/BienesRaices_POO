<?php 

require '../../includes/app.php';

use App\Vendedor;

autenticado();

//verificar y sanitizar ID
$id = $_GET['id'];
$id = filter_var( $id, FILTER_VALIDATE_INT);

//si no hay ningún id
if(!$id) {
    header('Location: /admin');
}

//buscar registro por id
$vendedor = Vendedor::find($id);

//consultar arreglo de errores
$errores = Vendedor::getErrores();

if($_SERVER["REQUEST_METHOD"] == 'POST') {

    
    //sincronizar objeto en memoria
    $resultado = $vendedor->sincronizar($_POST);

    //validar la entrada de datos
    $errores = $vendedor->validar();    
    
    if(empty($errores)) {
    
        $resultado = $vendedor->guardar();
    }
}

incluirTemplates('header', $inicio = false, $admin = true);
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Actualizar Vendedor(a)</h1>

        <?php 
            /**inyectar HTML */
            foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error?>
            </div>
        <?php endforeach; ?>

        <a href="../index.php" class="boton boton-verde">&lt;&lt;Regresar</a>

        <form class="formulario" method="POST"  >
            
            <?php include '../../includes/templates/formulario_vendedores.php'; ?>

            <input type="submit" value="Actualizar Vendedor" class="boton boton-verde">
        </form>
    </main>

<!--footer desde template php-->
<?php

incluirTemplates('footer');
?>
