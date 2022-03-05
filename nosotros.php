<?php 
    require 'includes/app.php'; 
    
    incluirTemplates('header');
?>

    <main class="contenedor seccion">
        <h1>Conoce sobre Nosotros</h1>

        <div class="contenido-nosotros">
            <div class="imagen">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="image/webp">
                    <source srcset="build/img/nosotros.jpg" type="image78jpeg">
                    <img src="build/img/nosotros.jpg" alt="imagen nosotros">
                </picture>
            </div>
    
            <div class="contenido-texto">
                <blockquote>25 Años De Experiencia</blockquote>
                <p>Proin consequat viverra sapien, malesuada tempor tortor feugiat vitae. In dictum felis et nunc aliquet molestie. Proin tristique commodo felis, sed auctor elit auctor pulvinar. Nunc porta, nibh quis convallis sollicitudin, arcu nisl semper mi, vitae sagittis lorem dolor non risus. Vivamus accumsan maximus est, eu mollis mi. Proin id nisl vel odio semper hendrerit. Nunc porta in justo finibus tempor. Suspendisse lobortis dolor quis elit suscipit molestie. Sed condimentum, erat at tempor finibus, urna nisi fermentum est, a dignissim nisi libero vel est. Donec et imperdiet augue. Curabitur malesuada sodales congue. Suspendisse potenti. Ut sit amet convallis nisi.</p>
                <p>Aliquam lectus magna, luctus vel gravida nec, iaculis ut augue. Praesent ac enim lorem. Quisque ac dignissim sem, non condimentum orci. Morbi a iaculis neque, ac euismod felis. Fusce augue quam, fermentum sed turpis nec, hendrerit dapibus ante. Cras mattis laoreet nibh, quis tincidunt odio fermentum vel. Nulla facilisi.</p>
            </div>
        </div>
        <div class="contenedor seccion">
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
        </div>
    </main>

<!--footer desde template php-->
<?php
    incluirTemplates('footer');
?>