<?php 
    require 'includes/app.php';    
    // incluirTemplates('header');
    require 'includes/templates/header.php';

    // $id = '';

    /**comprobando que query string esta presente utilizando
     * operador ternario
     */
    isset($_GET['id']) ? $id = $_GET['id'] : $id = null;
    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    if (!$id) {
        header('location: /');
    }
    
    // var_dump($id);
    // exit;

    //importar la conexion

    $conexion = conectaDB();

    //Realñizar la query
    $query = "SELECT * FROM propiedades WHERE id=${id}";

    //Leer resultados
    $resultado = mysqli_query($conexion, $query);

    // echo '<pre>';
    // var_dump($resultado->num_rows);
    // echo '</pre>';

    /**Si el id existe num_rows devuelve 1
     * Si no existe devuelve 0
     * redireccionar la página al inicio si el id no existe
     */
    if ($resultado->num_rows === 0) {
        header('location: /');
    }


    $propiedad = mysqli_fetch_assoc($resultado);
?>

    <main class="contenedor seccion contenido-centrado  ">
        <h1><?php echo $propiedad['titulo']; ?></h1>

        <div class="anuncio">
            <picture>
                <!-- <source srcset="build/img/destacada.webp" type="image/webp">
                <source srcset="build/img/destacada.jpg" type="image/jpeg"> -->
                <img loading="lazy" src="/uploads/<?php echo $propiedad['imagen']; ?>" alt="Imagen destacada">
            </piture>
    
            <div class="contenido-anuncio">
                <p class="precio">$<?php echo $propiedad['precio']; ?></p>
    
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono escusado">
                        <p><?php echo $propiedad['wc']; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorios">
                        <p><?php echo $propiedad['habitaciones']; ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamientos">
                        <p><?php echo $propiedad['estacionamiento']; ?></p>
                    </li>
                </ul>

                <p>
                    <?php echo $propiedad['descripcion']; ?>              
                </p>
            </div><!--.contenido-anuncio-->

        </div><!--.anuncio-->
    </main>

   

    <!--footer desde template php-->
    <?php
        mysqli_close($conexion);

        incluirTemplates('footer');
    ?>
