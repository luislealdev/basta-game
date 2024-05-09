<?php
session_start();

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] == 'admin') header('location: ../admin/');
    else header('location: ../game/');
}

// session_destroy();
include '../../class/captcha.php';
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
    <title>Inicio de sesión</title>
</head>

<body>
    <main class="flex justify-content align-center bg-notebook">
        <div class="flex column gap-15 bg-white p-40" style="min-width: 250px">
            <h1 class="primary-color f-size-24 center-text">Inicio de sesión</h1>
            <form action="/basta/class/acceso.php" method="POST" class="flex column">
                <input type="hidden" name='action' value='login'>
                <input type="text" name="mail" placeholder="mail@mail.com" class="input border-primary" />
                <input type="password" name="password" placeholder="Contraseña" class="input border-primary" />
                <div class="flex column">
                    <input type="text" name="captcha" placeholder="¿Cuánto es <?= $capchaText ?> ?" class="input border-primary" />
                    <a href="./recover-password.php" class="flex end f-size-14 mt-10 hover-underline">¿Olvidaste tu contraseña?</a>
                </div>
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
                <button type="submit" class="p-10 radius no-border mt-20 f-size-14 bg-primary white-text">Ingresar</button>
            </form>
            <a href="./register.php" class="p-10 radius no-border mt-10 center-text f-size-14 hover-underline">Crear una cuenta</a>
        </div>
    </main>
</body>

</html>