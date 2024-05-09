<?php
$ruta = "../../resources/files/";
var_dump($_FILES);

if (isset($_FILES['archivo']) && $_FILES['archivo']['name'] !== "" && $_FILES['archivo']['size'] < 1000 * 1024) {
    $nombreArchivo = $_FILES['archivo']['name'];
    if (!is_dir($ruta)) {
        mkdir($ruta);
    }
    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta . $nombreArchivo)) {
        echo "El archivo se ha cargado correctamente.";
    } else {
        echo "Error al cargar el archivo.";
    }
}

?>  
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivos</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="archivo">
        <input type="submit">
    </form>
    <?php
    if (is_dir($ruta)) {
        $dir = opendir($ruta);
        while ($archivo = readdir($dir)) {
            if ($archivo != '.' && $archivo != '..') {
                echo "<a href='$ruta/$archivo'>$archivo</a><br>";
            }
        }
        closedir($dir);
    }
    ?>
</body>

</html>