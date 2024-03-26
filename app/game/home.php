<?php
session_start();
if (!isset($_SESSION["nombre"])) header('location: ../auth/login.php');
if ($_SESSION["role"] == 'admin') header('location: ../admin/home.php');
?>

<!-- 
MENSAJES DE ERROR
     1: Error en las credenciales
     2: Los datos no han sido enviados
     3: Correo no registrado    
     4: Correo duplicado
     5: No hay sesión
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <p>Bienvenido <span> <?php echo $_SESSION["nombre"]; ?></span></p>
    <h1>Inicio</h1>
    <p>Las sesiones son un mecanismo para almacenar datos en el servidor,
        son hermanas de las cookies. La diferencia radica en que las sesiones tienen un tiempo de vida.</p>
    <br>
    <p>Las sesiones se registran en un archivo personalizado por cada conexión, en el caso de Xammp se guardan
        en la carpeta Xampp/tempp y se les puede reconocer fácilmente porque dicen sess y después una cadena de
        cifrado de la ip, sistema operativo, navegador e identificador de un navegador de la pestaña.
        De esta forma si la máquina intenta conectarse a un sitio, es la misma ip, el mismo sistema operativo,
        pero si se quiere conectar con otro navegador y otra pestaña es una sesión diferente. </p>
</body>

</html>