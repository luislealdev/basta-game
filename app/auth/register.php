<?php
session_start();
if (isset($_SESSION["role"])) {
   if ($_SESSION["role"] == 'admin') header('location: ../admin/home.php');
   else header('location: ../game/home.php');
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Register</title>
</head>

<body>
   <form action="/basta/class/acceso.php" method="POST">
      <input type="hidden" name='action' value='register'>
      <input type="text" name="nombre" placeholder="Nombre" />
      <input type="text" name="apellidos" placeholder="Apellidos" />
      <input type="text" name="correo" placeholder="mail@mail.com" />

      <input type="password" name="password" placeholder="Contraseña" />
      <!-- <?php
      if (isset($_GET['e'])) {
         if ($_GET['e'] == 1) {
            echo "Error en las credenciales";
         } else if ($_GET['e'] == 2) {
            echo "Los datos no han sido enviados";
         }
      }
      ?> -->
      <input type="submit" value="Ingresar" />
   </form>
</body>

</html>