<?php

    require '../includes/app.php';


    autenticado();

    /**===COMPROBAR EL QUERY STRING=== */
    $queryString = '';
    /**comprobar si el query string existe con if*/    
    // if(isset($_GET['resultado'])) {
    //     $queryString = $_GET['resultado'];
    // }

    /**comprobando que query string esta presente utilizando
     * operador ternario
     */
    isset($_GET['resultado']) ? $queryString = $_GET['resultado'] : $queryString = null;

    /**comprobando si el query string esta presente utilizando
     * el operador ?? 
     */
    $queryString = $_GET['resultado'] ?? null;

    /** == PASOS PARA CONSULTAR LA BASE DE DATOS ==*/

    //PASO 1: Importar la conexión

    $db = conectaDB();


    //PASO 2: Realizar el query
    $queryPropiedades = "SELECT * FROM propiedades";

    //PASO 3: Consultar la DB
    $resultadoQuery = mysqli_query($db, $queryPropiedades);
    

    /**==== ELIMINA PROPIEDAD ===== */

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if($id) {
            //Elimina la imagen del repositorio
            $query = "SELECT imagen FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);
            $imgNombre = mysqli_fetch_assoc($resultado);
            var_dump($imgNombre['imagen']);

            unlink('../uploads/' . $imgNombre['imagen']);

            //Elima el registro de la DB
            $query = "DELETE FROM propiedades WHERE id = ${id}";
            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                header('location: /admin?resultado=3');
            }
        }        
    }

    incluirTemplates('header', $inicio = false, $admin = true);

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Administrador de Bienes Raices</h1>

    <?php if (intval($queryString) === 1) :?>
        <div class="alerta correcto id-1">
            <?php echo 'Propiedad creada con éxito'?>
        </div>
    <?php elseif(intval($queryString) === 2) : ?>
        <div class="alerta correcto id-2">
            <?php echo 'Propiedad actualizada correctamente'?>
        </div>
    <?php elseif(intval($queryString) === 3) : ?>
        <div class="alerta correcto id-3">
            <?php echo 'Propiedad eliminada correctamente'?>
        </div>
    <?php endif ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Descripcion</th>
                <th>Vendedor</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <!-- PASO 5: Mostrar los resultados -->
        <?php while ($propiedad = mysqli_fetch_assoc($resultadoQuery)) : ?>
        <tbody>
            <tr>
                <td><?php echo $propiedad['id']; ?></td>
                <td><?php echo $propiedad['titulo']; ?></td>
                <td>$<?php echo $propiedad['precio']; ?> </td>
                <td class="imagen-propiedad"><img src="/uploads/<?php echo $propiedad['imagen']; ?>" alt="imagen propiedad"></td>
                <td><?php echo $propiedad['descripcion']; ?></td>
                <?php 
                    //PASO 2: Realizar el query
                    $vendedorId =  $propiedad['vendedorId'];  
                    $queryVendedores = "SELECT * FROM vendedores WHERE id=${vendedorId}";

                    //PASO 3: Consultar la DB                    
                    $resultadoQueryV = mysqli_query($db, $queryVendedores);
                    $vendedor = mysqli_fetch_assoc($resultadoQueryV);
                ?>                
                <td><?php echo  $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?></td>
                <td>

                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>

                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
        </tbody>
        <?php endwhile ?>
    </table>

    <!-- PASO 6: Cerrar la conexión -->
    <?php mysqli_close($db) ?>
    
</main>

<!--footer desde template php-->
<?php
    include '../includes/templates/footer.php';
?>