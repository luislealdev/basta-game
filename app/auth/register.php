<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// COMPONENTS AND UTILS
include '../../class/captcha.php';

session_start();
if (isset($_SESSION["role"])) {
   if ($_SESSION["role"] == 'admin') header('location: ../admin/home.php');
   else header('location: ../game/home.php');
}

// We change the session_destroy() function to the following:
session_unset();
// $loginResult = $registerResult - $result = 0;
$loginCap = $oCaptcha->captcha();
$capchaText = explode('=', $loginCap)[0];
$_SESSION['cap_login'] = explode('=', $loginCap)[1];
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="https://luisrrleal.com/styles/leal-styles.css">
   <link rel="stylesheet" href="../../public/global.css">
   <title>Register</title>
</head>

<body>
   <main class="flex justify-content align-center bg-notebook">
      <div class="flex column gap-15 bg-white p-40" style="min-width: 250px">
         <h1 class="primary-color f-size-24 center-text">Registro</h1>
         <form action="/basta/class/acceso.php" method="POST" class="flex column">
            <input type="hidden" name='action' value='register'>
            <input type="text" name="nombre" placeholder="Nombre" class="input border-primary">
            <input type="text" name="apellidos" placeholder="Apellidos" class="input border-primary">
            <input type="text" name="mail" placeholder="mail@mail.com" class="input border-primary" />
            <input type="text" name="captcha" placeholder="¿Cuánto es <?= $capchaText ?>?" class="input border-primary" />
            <?php
            if (isset($_GET['e'])) {
               if ($_GET['e'] == 1) {
                  echo "Error en las credenciales";
               } else if ($_GET['e'] == 2) {
                  echo "Los datos no han sido enviados";
               } else if ($_GET['e'] == 3) {
                  echo "Error en el captcha";
               }
            }
            ?>
            <button type="submit" class="p-10 radius no-border mt-20 f-size-14 bg-primary white-text">Registrarse ahora</button>
         </form>
         <a href="./" class="p-10 radius no-border mt-10 center-text f-size-14 hover-underline">¿Ya tienes una cuenta?</a>
      </div>
   </main>

</body>

</html>