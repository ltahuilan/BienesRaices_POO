<fieldset>
    <legend>Imformación General</legend>

    <div class="grupo">
        <label for="titulo">Titulo:</label>
        <input 
            type="text"
            id="titulo"
            name="titulo"
            placeholder="Titulo de propiedad"
            value="<?php echo sntzr($propiedad->titulo); ?>">
    </div>

    <div class="grupo">
        <label for="precio">Precio:</label>
        <input
            type="text"
            id="precio"
            name="precio"
            placeholder="Precio de propiedad"
            value="<?php echo sntzr($propiedad->precio); ?>">                    
    </div>

    <div class="grupo">
        <label for="imagen">Imagen:</label>
        <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">  
        <?php if($propiedad->imagen) : ?>
            <img src="<?php echo '../../uploads/'.$propiedad->imagen; ?>" alt="imagen" class="img-sm">                  
        <?php endif; ?>
    </div>
    <div class="grupo">
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" placeholder="Descripcion de la propiedad"><?php echo sntzr($propiedad->descripcion); ?></textarea>
    </div>

</fieldset>

<fieldset>
    <legend>Características</legend>

    <div class="grupo">
        <label for="habitaciones">Número de Habitaciones:</label>
        <input
            type="number"
            id="habitaciones"
            name="habitaciones"
            min="1" max="20"
            placeholder="Ej.: 3"
            value="<?php echo sntzr($propiedad->habitaciones); ?>">
    </div>

    <div class="grupo">
        <label for="wc">Número de Baños:</label>
        <input
            type="number"
            id="wc"
            name="wc"
            min="1" max="20"
            placeholder="Ej.: 3"
            value="<?php echo sntzr($propiedad->wc); ?>">
    </div>

    <div class="grupo">
        <label for="estacionamiento">Número de Estacionamientos:</label>
        <input
            type="number"
            id="estacionamiento"
            name="estacionamiento"
            min="0" max="20"
            placeholder="A partir de 0"
            value="<?php echo sntzr($propiedad->estacionamiento); ?>">
    </div>
</fieldset>

<fieldset>
    <legend>Vendedores</legend>
    <div class="grupo">
        <select name="vendedorId" >
            <option value="1">-- Seleccionar --</option>


        </select>
    </div>
</fieldset>