
<?php

    /**Variable de apoyo para detectar la página index
     * Si esta presente agrega el texto 'inicio' a las clases
     * definidas en el header
     */
    require 'includes/app.php';
    
    incluirTemplates('header', $inicio = true);
?>
    <main class="contenedor seccion">
        <h1>M&aacute;s Sobre Nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad">
                <h3>Seguridad</h3>
                <p>Fuga tenetur possimus corrupti qui, maxime harum accusantium ab aperiam voluptatem velit! Quibusdam assumenda hic earum necessitatibus unde doloremque sunt ab fugiat.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio">
                <h3>El Mejor Precio</h3>
                <p>Fuga tenetur possimus corrupti qui, maxime harum accusantium ab aperiam voluptatem velit! Quibusdam assumenda hic earum necessitatibus unde doloremque sunt ab fugiat.</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo">
                <h3>A Tiempo</h3>
                <p>Fuga tenetur possimus corrupti qui, maxime harum accusantium ab aperiam voluptatem velit! Quibusdam assumenda hic earum necessitatibus unde doloremque sunt ab fugiat.</p>
            </div>
        </div>
    </main>

    <section class="seccion contenedor">
        <h2>Casas y Depas en Venta</h2>

        <?php 
            $limite = 3;
            require 'includes/templates/anuncios.php';  
        ?>
        

        <div class="alinear-derecha">
            <a class="boton-verde" href="anuncio.php">Ver Todas</a>
        </div>
    </section>

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y un asesor se pondr&aacute; en contacto contigo a la brevedad</p>
        <a class="boton-amarillo" href="contacto.php">Cont&aacute;ctanos</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>
            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog1.webp" type="image/webp">
                        <source srcset="build/img/blog1.jpg" type="image/jpeg">
                        <img loading="lazy" src="build/img/blog1.jpg" alt="Imegn blog">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="blog.php">
                        <h4>Terraza en el techo de tu casa</h4>
                        <p class="informacion-meta">Escrito el: <span>10/07/2021</span> Por: <span>Admin</span></p>
                        <p>Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero 
                        </p>
                    </a>
                </div>
            </article>

            <article class="entrada-blog">
                <div class="imagen">
                    <picture>
                        <source srcset="build/img/blog2.webp" type="image/webp">
                        <source srcset="build/img/blog2.jpg" type="image/jpeg">
                        <img loading="lazy" src="build/img/blog2.jpg" alt="Imegn blog">
                    </picture>
                </div>
                <div class="texto-entrada">
                    <a href="blog.php">
                        <h4>Gu&iacute;a para la decoraci&oacute;n de tu hogar</h4>
                        <p class="informacion-meta">Escrito el: <span>10/07/2021</span> Por: <span>Admin</span></p>
                        <p>Maximiza el espacio en tu hogar con esta gu&iacute;a, aprende a combinar muebles y colores para darle vida a tu espacio.
                        </p>
                    </a>
                </div>
            </article>
        </section><!--.blog-->

        <section class="testimoniales">
            <h3>Testimoniales</h3>
            <div class="testimonial">
                <blockquote>
                    El personal se comport&oacute; de una excelente forma, muy buena atenci&oacute;n y la casa que me ofrecieron cumple con todas mis expectativas. 
                </blockquote>
                <p>- Luis Tahuil&aacute;n</p>
            </div>
        </section>
    </div>

   <!--footer desde template php-->
<?php
    incluirTemplates('footer');
?>