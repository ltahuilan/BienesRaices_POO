<?PHP 

    if (!isset($_SESSION)) {
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bines Raices <?php echo $admin ? '- Admin' : '' ?></title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <!--Si la variable $inicio esta definida agrega la cadena de texto 'inicio'-->
    <header class="header <?php echo $inicio ? 'inicio' : ''?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/index.php" class="logo">
                    <img src="/src/img/logo.svg" alt="Logo Bienes Raices">
                </a>
                
                <div class="mobil-menu">
                    <img src="/build/img/barras.svg" alt="icono mobil-menu">
                </div>

                <div class="derecha">
                    <img src="/build/img/dark-mode.svg" alt="icono dark-mode" class="dark-mode-boton">
                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                        <?php if($auth) : ?>
                            <a href="/logout.php" class="sesion">Cerrar Sesión</a>
                        <?php else :?>    
                            <a href="/login.php" class="sesion">Login</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div><!--.barra-->

            <h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>
        </div>
    </header>