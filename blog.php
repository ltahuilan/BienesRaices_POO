<?php 
    require 'includes/app.php'; 
    
    incluirTemplates('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Nuestro Blog</h1>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog1.webp" type="image/webp">
                    <source srcset="build/img/blog1.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog1.jpg" alt="Imegn blog">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada-blog.php">
                    <h4>Terraza en el techo de tu casa</h4>
                    <p class="informacion-meta">Escrito el: <span>27/08/2021</span> Por: <span>Admin</span></p>
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
                <a href="entrada-blog.php">
                    <h4>Gu&iacute;a para la decoraci&oacute;n de tu hogar</h4>
                    <p class="informacion-meta">Escrito el: <span>27/08/2021</span> Por: <span>Admin</span></p>
                    <p>Maximiza el espacio en tu hogar con esta gu&iacute;a, aprende a combinar muebles y colores para darle vida a tu espacio.
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog3.webp" type="image/webp">
                    <source srcset="build/img/blog3.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog3.jpg" alt="Imegn blog">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada-blog.php">
                    <h4>La combinaci&oacute;n perfecta para tus interiores</h4>
                    <p class="informacion-meta">Escrito el: <span>27/08/2021</span> Por: <span>Admin</span></p>
                    <p>Consejos para construir una terraza en el techo de tu casa con los mejores materiales y ahorrando dinero 
                    </p>
                </a>
            </div>
        </article>

        <article class="entrada-blog">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/blog4.webp" type="image/webp">
                    <source srcset="build/img/blog4.jpg" type="image/jpeg">
                    <img loading="lazy" src="build/img/blog4.jpg" alt="Imegn blog">
                </picture>
            </div>
            <div class="texto-entrada">
                <a href="entrada-blog.php">
                    <h4>Gu&iacute;a de compras</h4>
                    <p class="informacion-meta">Escrito el: <span>27/08/2021</span> Por: <span>Admin</span></p>
                    <p>Maximiza el espacio en tu hogar con esta gu&iacute;a, aprende a combinar muebles y colores para darle vida a tu espacio.
                    </p>
                </a>
            </div>
        </article>
    </main>

    <!--footer desde template php-->
    <?php
        incluirTemplates('footer');
    ?>