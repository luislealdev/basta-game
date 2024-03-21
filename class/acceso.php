<?php
session_start();

include 'baseDeDatos.php';
class Acceso extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formLogin':
                break;

            case 'login':
                $result = $this->login();

            case 'formRecord':
                break;

            case 'record':
                break;

            case 'formPwd':
                break;

            case 'retrievePwd':
                break;

            default:
        }

        return $result;
    }
    function login()
    {
        if (isset($_POST['mail']) && isset($_POST['password'])) {
            // Obtenemos el correo y lo guardamos en una variable
            $correo = $_POST['mail'];
            // Obtenemos la contraseña y la guardamos en una variable
            $pass = $_POST['password'];
            // Conectamos a la base de datos
            // El uso de la base de datos está dividido en tres pasos
            // Paso 1: Abrir la conexión
            // Paso 2: Procesar la consulta
            // 2.1 Realizar la consulta
            $query = "select * from usuario where email = '$correo' and clave = '$pass';";
            $registro = $this->getRecord($query);
            // 2.2 Procesar el resultado
            if ($this->num_registros == 1) {
                // Si es un usuario registrado
                $_SESSION['correo'] = $correo;
                $_SESSION['nombre'] = $registro->nombre . ' ' . $registro->apellidos;
                $_SESSION['id'] = $registro->id_usuario;
                $_SESSION['foto'] = $registro->foto;
                header('location: ../home.php');
            } else
                // Error en las credenciales reenviar localidad del usuario
                header('location: ../index.php?e=1');
        } else {
            header('location: ../index.php?e=2');
        };
    }
}

// Funciones de php para imprimir elementos compuestos
// var_dump($_POST);
// print_r($_POST);

$oAcceso = new Acceso();
if (isset($_REQUEST['action'])) echo $oAcceso->action($_REQUEST['action']);
