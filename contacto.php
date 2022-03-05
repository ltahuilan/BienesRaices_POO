<?php 
    require 'includes/app.php'; 
    
    incluirTemplates('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Contacto</h1>

        <div class="imagen">
            <picture>
                <source srcset="build/img/destacada3.webp" type="image/webp">
                <source srcset="build/img/destacada3.jpg" type="image/jpeg">
                <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen de contacto">
            </picture>
        </div>

        <form class="formulario">
            <fieldset>
                <legend>Imformaci&oacute;n Personal</legend>
                <div class="grupo">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" placeholder="Tu nombre">
                </div>

                <div class="grupo">
                    <label for="email">Email:</label>
                    <input type="mail" id="email" placeholder="Tu email">
                </div>

                <div class="grupo">
                    <label for="telefono">Telefono:</label>
                    <input type="tel" id="telefono" placeholder="Tu teléfono">
                </div>

                <div class="grupo">
                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" placeholder="Escribe tu mensaje"></textarea>
                </div>                
            </fieldset>

            <fieldset>
                <legend>Informaci&oacute;n sobre la propiedad</legend>
                <div class="grupo">
                    <label for="opciones">Vender o comprar</label>
                    <select id="opciones">
                        <option value="" disabled selected>-- Seleccione opción --</option>
                        <option value="comprar">Comprar</option>
                        <option value="vender">Vender</option>
                    </select>
                </div>

                <div class="grupo">
                    <label for="presupuesto">Seleccione Presupuesto</label>
                    <input type="number" placeholder="Tu presupuesto o precio" id="presupuesto" min="1000000">
                </div>
            </fieldset>


            <fieldset>
                <legend>Informaci&oacute;n sobre la propiedad</legend>

                <p>C&oacute;mo desea ser contactado</p>
                <div class="grupo contacto">
                    <label for="contacto">Teléfono</label>
                    <input type="radio" value="telefono" name="contacto" id="contacto-telefono">
                    <label for="contacto">E-mail</label>
                    <input type="radio" value="mail" name="contacto" id="contacto-email">
                </div>

                <p>Si eligió teléfono, seleccione la fecha y la hora</p>

                <div class="grupo">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha">
                </div>

                <div class="grupo">
                    <label for="hora">Hora:</label>
                    <input type="time" id="hora" min="09:00" max="19:00">
                </div>
            </fieldset>

            <input type="submit" value="Enviar" class="boton">
        </form>
    </main>

    <!--footer desde template php-->
    <?php
        incluirTemplates('footer');
    ?>