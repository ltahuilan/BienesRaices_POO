<?php 


    include 'includes/app.php';
    $conexion = conectaDB();
    
    $errores = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $email = mysqli_real_escape_string( $conexion, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string( $conexion, $_POST['password'] );
        
        session_start();
        $_SESSION = [];
        
        if (!$email) {            
            $errores[] = 'El correo es obligatorio o no se ingresó uno valido';
            $_SESSION['err_mail'] = 'El correo es obligatorio o no se ingresó uno valido';

        }
        
        if (!$password){
            $errores[] = 'El password es obligatorio';
            $_SESSION['err_psw'] ='El password es obligatorio';

        }

        if (empty($errores)) {

            //verificando que el usuario exista
            $query = "SELECT * FROM usuarios WHERE email = '${email}'";
            $resultado = mysqli_query($conexion, $query);

            /**num_rows forma parte del objeto object(mysqli_result 
             * num_rows tiene valor de 0, no hay resultados en la consulta
             * num_rows tiene valor de 1, si hay resultados
             * num_rows puede evaluarse en el sentido de si exite harcer algo
            */
            if ($resultado->num_rows) {

                // revisar si el Password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['password']);

                if ($auth) {
                    //password correcto
                    session_start();

                    //agregando elementos al arreglo de la superglobal $_SESSION
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;

                    header ('location: /admin');

                }else {
                    $errores['psw_inc'] = 'El password no es correcto';
                    $_SESSION['psw_inc'] = 'El password no es correcto';

                }

            }else {
                $errores['usr_unr'] = 'El usuario no esta registrado, compruebe los datos';
                $_SESSION['usr_unr'] = 'El usuario no esta registrado, compruebe los datos';
            }
            
        }

    }



    //Iincluir el header   
    incluirTemplates('header');

?>

    <main class="contenedor seccion contenido-centrado-60">
        <h1>Acceso Usuarios</h1>

        <?php foreach($errores as $error) : ?>
            <div class="alerta error">
                <?php echo $error?>
            </div>
        <?php endforeach ?>


        <form method="POST" action="" class="formulario">
            <fieldset>
                <legend>Acceso a usuarios registrados</legend>

                <div class="grupo">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Tu email" value="">
                </div>
    
                <div class="grupo">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" placeholder="Escribe tu password">
                    
                </div>                
            </fieldset>

            <input type="submit" class="boton boton-verde" value="Inicar Sesión">

        </form>
    </main>

<!--footer desde template php-->
<?php
    incluirTemplates('footer');
?>