<fieldset>
    <legend>Imformación General</legend>

    <div class="grupo">
        <label for="nombre">Nombre:</label>
        <input 
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre de vendedor(a)"
            value="<?php echo sntzr($vendedor->nombre); ?>">
    </div>

    <div class="grupo">
        <label for="apellido">Apellido:</label>
        <input
            type="text"
            id="apellido"
            name="apellido"
            placeholder="Apellido de vendedor(a)"
            value="<?php echo sntzr($vendedor->apellido); ?>">                    
    </div>

</fieldset>

<fieldset>
    <legend>Información de contacto</legend>

    <div class="grupo">
        <label for="apellido">Telefono:</label>
        <input
            type="tel"
            id="telefono"
            name="telefono"
            placeholder="Telefono de vendedor(a)"
            value="<?php echo sntzr($vendedor->telefono); ?>">                    
    </div>

    <div class="grupo">
        <label for="email">E-mail:</label>
        <input
            type="mail"
            id="email"
            name="email"
            placeholder="email vendedor(a)"
            value="<?php echo sntzr($vendedor->email); ?>">                    
    </div>


</fieldset>

