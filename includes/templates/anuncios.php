<?php 

    use App\Propiedad;
    
    /**si la url accedida es anunicios.php llamar el método all()
     * de lo contrario, el metdo get(), el cual tiene un limite para
     * mostrar registros.
     */
    if($_SERVER['REQUEST_URI'] === '/anuncios.php') {
        $propiedades = Propiedad::all();
    }else {
        $propiedades = Propiedad::get(3);
    }
 
?>


<div class="contenedor-anuncios">
    <?php foreach ($propiedades as $propiedad) : ?>
    <div class="anuncio">
        <picture>
            <!-- <source srcset="build/img/anuncio1.webp" type="image/webp">
            <source srcset="build/img/anuncio1.jpeg" type="image/jpeg"> -->
            <img loading="lazy" src="/uploads/<?php echo $propiedad->imagen?>" alt="anuncio">
        </picture>

        <div class="contenido-anuncio">
            <h3><?php echo $propiedad->titulo; ?></h3>
            <p><?php echo $propiedad->descripcion; ?></p>
            <p class="precio"><?php echo $propiedad->precio; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono escusado">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono dormitorios">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamientos">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
            </ul>
            <a class="boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad->id;?>">Ver Propiedad</a>
        </div><!--.contenido-anuncio-->
    </div><!--.anuncio-->

    <?php endforeach; ?>

</div> <!--.contenedor-anuncios-->


