<?php 
    //importar conexion
    include 'includes/app.php';
    $conexion = conectaDB();

    $email = 'correo@correo.com';
    $password = '12345';

    //Aplicar hash al password
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    
    
    //realizar query
    $query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password_hash')";
    

    exit;

    //obtener datos
    $resultado = mysqli_query($conexion, $query);
?>