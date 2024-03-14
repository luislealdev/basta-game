<?php
// Recibir los datos del formulario, revisar en base de datos que concuerden y redirigir al lugar pertinente

// Obtenemos el correo y lo guardamos en una variable
$correo = $_POST['mail'];
// Obtenemos la contraseña y la guardamos en una variable
$pass = $_POST['password'];


// Conectamos a la base de datos
// El uso de la base de datos está dividido en tres pasos

// Paso 1: Abrir la conexión
$con = mysqli_connect('localhost', 'basta', '1234', 'basta');

if ($con == null) exit;
else {
    // Paso 2: Procesar la consulta
    // 2.1 Realizar la consulta
    $query = "select * from usuario where correo = '$correo' and clave = '$pass'";
    echo $query;
    $usuario = mysqli_query($con, $query);
    // 2.2 Procesar el resultado

}


// Paso 3: Cerrar la conexión
mysqli_close($con);

echo "Ya llegueee!";
