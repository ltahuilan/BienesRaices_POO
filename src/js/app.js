document.addEventListener('DOMContentLoaded', function() {

    eventsListeners();
    darkMode();
    removerAlerta();

});

function eventsListeners() {
    const menu = document.querySelector('.mobil-menu');
    menu.addEventListener('click', function() {
        const navegacion = document.querySelector('.navegacion');

        if(navegacion.classList.contains('mostrar')) {
            navegacion.classList.remove('mostrar')
        }else {
            navegacion.classList.add('mostrar');
        };

        /**Modo corto con el método toggle */
        // navegacion.classList.toggle('mostrar');
    });
};

function darkMode() {

    /**acceder a las preferencias del sistema para detectar el tema configurado */
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if(prefiereDarkMode.matches) {
        // document.body.classList.add('dark-mode');
    }else{
        // document.body.classList.remove('dark-mode');
    }

    /**Escuchar los cambios de ajustes en el tema en las preferencias del sistema
     *  para ajuste automático.
     */
    prefiereDarkMode.addEventListener('change', function() {
        if(prefiereDarkMode.matches) {
            // document.body.classList.add('dark-mode');
        }else{
            // document.body.classList.remove('dark-mode');
        }
    });

    
    /**seleccion manual por usuario */
    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');

        /**almacenando las preferencias en localStorage 
        * para leer en automatico si la página es cerrada
        */
       if(document.body.classList.contains('dark-mode')) {
           localStorage.setItem('dark-mode-seleccionado', 'true');
       }else{
           localStorage.setItem('dark-mode-seleccionado', 'false');
       }

    });

    /**Obtener las preferencias almacenadas en el local storge */
    if(localStorage.getItem('dark-mode-seleccionado') === 'true') {
        document.body.classList.add('dark-mode');
    }
};


function removerAlerta() {
    const alerta = document.querySelector('.correcto');

    setTimeout(() => {
        alerta.remove();
    }, 3500);
}