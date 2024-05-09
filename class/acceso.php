<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include 'baseDeDatos.php';
include 'captcha.php';
class Acceso extends BaseDeDatos
{
    function action($cual)
    {
        // $result = '';
        switch ($cual) {
            case 'login':
                $this->login();

            case 'register':
                $this->register();

            case 'recoverPwd':
                $this->recoverPwd();
            default:
        }
    }

    function login()
    {
        if (!is_numeric($_POST['captcha']) || $_POST['captcha'] != $_SESSION['cap_login'])
            header('location: ../app/auth/login.php?e=3');

        if (isset($_POST['mail']) && isset($_POST['password'])) {
            // Obtenemos el correo y lo guardamos en una variable
            $correo = $_POST['mail'];
            // Obtenemos la contraseña y la guardamos en una variable
            // Encriptamos contraseña para evitar inyección de código SQL
            $pass = $_POST['password'];
            // Conectamos a la base de datos
            // El uso de la base de datos está dividido en tres pasos
            // Paso 1: Abrir la conexión
            // Paso 2: Procesar la consulta
            // 2.1 Realizar la consulta

            $query = "SELECT u.nombre, u.apellidos, u.id_usuario, u.foto, tu.nombre AS role FROM usuario u JOIN tipo_usuario tu ON tu.id_tipo_usuario = u.tipo_usuario WHERE u.email = '$correo' AND u.clave = PASSWORD('$pass');";
            echo $query;
            $registro = $this->getRecord($query);
            // 2.2 Procesar el resultado
            if ($this->num_registros == 1) {
                // Si es un usuario registrado
                $_SESSION['correo'] = $correo;
                $_SESSION['nombre'] = $registro->nombre . ' ' . $registro->apellidos;
                $_SESSION['id'] = $registro->id_usuario;
                $_SESSION['foto'] = $registro->foto;
                $_SESSION['role'] = $registro->role;
                if ($registro->role == 'admin')
                    header('location: ../app/admin/home.php');
                else
                    header('location: ../app/game/');
            } else
                // Error en las credenciales reenviar localidad del usuario
                header('location: ../app/auth/index.php?e=1');
        } else {
            header('location: ../app/auth/index.php?e=1');
        };
    }

    function register()
    {
        $cadena = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789123456789";
        $numeC = strlen($cadena);
        $nuevPWD = "";

        // Generate random password
        for ($i = 0; $i < 8; $i++)
            $nuevPWD .= $cadena[rand() % $numeC];

        // $cad = "insert into usuario set nombre='" . $_POST['nombre'] . "', apellidos='" . $_POST['apellidos'] . "', email='" . $_POST['correo'] . "', clave=password('" . $nuevPWD . "'), fechaUltiAcceso=n" . date('Y-m-d') . ", tipo_usuario=2";
        $cad = "insert into usuario(nombre, apellidos, email, clave, fechaUltiAcceso) values('" . $_POST['nombre'] . "', '" . $_POST['apellidos'] . "', '" . $_POST['mail'] . "', password('" . $nuevPWD . "'), '" . date('Y-m-d') . "')";

        include("../resources/class.phpmailer.php");
        include("../resources/class.smtp.php");

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com"; //mail.google
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Port = 465;     // set the SMTP port for the GMAIL server
        $mail->SMTPDebug  = 1;  // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth = true;   //enable SMTP authentication

        $mail->Username =   "21030076@itcelaya.edu.mx"; // SMTP account username

        // TODO: Get gmail password for app not secure
        $mail->Password = "";  // SMTP account password

        $mail->From = "BASTA GAME";
        $mail->FromName = "Basta Juego";
        $mail->Subject = "Registro completo";
        $mail->MsgHTML("<h1>BIENVENIDO " . $_POST['nombre'] . " " . $_POST['apellidos'] . "</h1><h2> tu clave de acceso es : " . $nuevPWD . "</h2>");
        $mail->AddAddress($_POST['mail']);
        //$mail->AddAddress("admin@admin.com");
        if (!$mail->Send())
            echo  "Error: " . $mail->ErrorInfo;
        else {
            $this->query($cad);
            header("location: ../app/auth/email-sended.php?e=7");
        }
    }

    function recoverPwd()
    {

        if (!is_numeric($_POST['captcha']) || $_POST['captcha'] != $_SESSION['cap_login'])
            header('location: ../app/auth/recover-password.php?e=3');

        $cadena = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789123456789";
        $numeC = strlen($cadena);
        $nuevPWD = "";


        // Generate random password
        for ($i = 0; $i < 8; $i++)
            $nuevPWD .= $cadena[rand() % $numeC];

        $cad = "update usuario set clave = '" . $nuevPWD . "' where email = '" . $_POST['mail'] . "';";

        include("../resources/class.phpmailer.php");
        include("../resources/class.smtp.php");

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com"; //mail.google
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Port = 465;     // set the SMTP port for the GMAIL server
        $mail->SMTPDebug  = 1;  // enables SMTP debug information (for testing)
        // 1 = errors and messages
        // 2 = messages only
        $mail->SMTPAuth = true;   //enable SMTP authentication

        $mail->Username =   "21030076@itcelaya.edu.mx"; // SMTP account username

        // TODO: Get gmail password for app not secure
        $mail->Password = "";  // SMTP account password

        $mail->From = "BASTA GAME";
        $mail->FromName = "Basta Juego";
        $mail->Subject = "Recuperación de contraseña";
        $mail->MsgHTML("<h1> RECUPERACIÓN DE CONTRASEÑA </h1><h2> Tu clave de acceso es : " . $nuevPWD . "</h2>");

        $mail->AddAddress($_POST['mail']);
        //$mail->AddAddress("admin@admin.com");
        if (!$mail->Send())
            echo  "Error: " . $mail->ErrorInfo;
        else {
            $this->query($cad);
            header("location: ../app/auth/email-sended.php?e=7");
        }
    }
}

// Funciones de php para imprimir elementos compuestos
// var_dump($_POST);
// print_r($_POST);

$oAcceso = new Acceso();
if (isset($_REQUEST['action'])) echo $oAcceso->action($_REQUEST['action']);
