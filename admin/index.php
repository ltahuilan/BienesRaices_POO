<?php

    require '../includes/app.php';

    use App\Propiedad;
    use App\Vendedor;

    autenticado();

    /**===COMPROBAR EL QUERY STRING=== */
    $resultado = '';
    /**comprobar si el query string existe con if*/    
    // if(isset($_GET['resultado'])) {
    //     $queryString = $_GET['resultado'];
    // }

    /**comprobando que query string esta presente utilizando operador ternario */
    //isset($_GET['resultado']) ? $queryString = $_GET['resultado'] : $queryString = null;

    /**comprobando si el query string esta presente utilizando el operador ?? */
    $resultado = $_GET['resultado'] ?? null;

    //mostrar todos los registros
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();


    /**==== ELIMINA REGISTRO ===== */

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $tipo = $_POST['tipo'];

        //avaluar si el tipo de entidad es propiedad o vendedor
        if (validarTipo($tipo)) {
            
            if($tipo === 'propiedad'){
                $propiedad = Propiedad::find($id);
                $propiedad->eliminar();
            }else {
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            }
        }       
    }

    incluirTemplates('header', $inicio = false, $admin = true);

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Administrador de Bienes Raices</h1>

    <?php $mensaje = mostrarAlerta( intval($resultado) );    
        if($mensaje) : ?>
            <p class="alerta correcto"><?php echo $mensaje?></p>
    <?php endif; ?>
    
    
    <h2>Propiedades</h2>

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
        <?php foreach($propiedades as $propiedad) : ?>
        <tbody>
            <tr>
                <td><?php echo $propiedad->id; ?></td>
                <td><?php echo $propiedad->titulo; ?></td>
                <td>$<?php echo $propiedad->precio; ?> </td>
                <td class="imagen-propiedad"><img src="/uploads/<?php echo $propiedad->imagen; ?>" alt="imagen propiedad"></td>
                <td><?php echo $propiedad->descripcion; ?></td>

                <?php 
                    //PASO 2: Realizar el query
                    $vendedorId =  $propiedad->vendedorId;  
                    $queryVendedores = "SELECT * FROM vendedores WHERE id=${vendedorId}";

                    //PASO 3: Consultar la DB                    
                    $resultadoQueryV = mysqli_query($db, $queryVendedores);
                    $vendedor = mysqli_fetch_assoc($resultadoQueryV);
                ?>
                            
                <td><?php echo  $vendedor['nombre'] . ' ' . $vendedor['apellido']; ?></td>
                <td>

                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                    <input type="hidden" name="tipo" value="propiedad">
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>

                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
        </tbody>
        <?php endforeach ?>
    </table>

    <h2>Vendedores</h2>

    <a href="/admin/vendedores/crear.php" class="boton boton-verde">Nuevo Vendedor</a>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <!-- PASO 5: Mostrar los resultados -->
        <?php foreach($vendedores as $vendedor) : ?>
        <tbody>
            <tr>
                <td><?php echo $vendedor->id; ?></td>
                <td><?php echo $vendedor->nombre . ' ' . $vendedor->apellido; ?></td>
                <td><?php echo $vendedor->telefono; ?> </td>
                <td><?php echo $vendedor->email; ?> </td>

                <td>
                    <form method="POST" class="w-100">
                        <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                        <input type="hidden" name="tipo" value="vendedor">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>

                    <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
        </tbody>
        <?php endforeach ?>
    </table>
    
</main>

<!--footer desde template php-->
<?php
    include '../includes/templates/footer.php';
?>