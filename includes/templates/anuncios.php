<?php 

    // //importar la conexion

    $conexion = conectaDB();
    

    //Realizar el query
    $query = "SELECT * FROM propiedades LIMIT ${limite}";
    
    
    //obtener el resultado
    $resultado = mysqli_query($conexion, $query);
 
?>


<div class="contenedor-anuncios">
    <?PHP while ($propiedad = mysqli_fetch_assoc($resultado)) : ?>
    <div class="anuncio">
        <picture>
            <!-- <source srcset="build/img/anuncio1.webp" type="image/webp">
            <source srcset="build/img/anuncio1.jpeg" type="image/jpeg"> -->
            <img loading="lazy" src="/upload_img/<?php echo $propiedad['imagen']?>" alt="anuncio">
        </picture>

        <div class="contenido-anuncio">
            <h3><?php echo $propiedad['titulo']; ?></h3>
            <p><?php echo $propiedad['descripcion']; ?></p>
            <p class="precio"><?php echo $propiedad['precio']; ?></p>
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
            <a class="boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad['id'];?>">Ver Propiedad</a>
        </div><!--.contenido-anuncio-->
    </div><!--.anuncio-->

    <?php endwhile; ?>

</div> <!--.contenedor-anuncios-->

<?php 
    
    //Cerrar la conexión
    mysqli_close($conexion);

?>


