<?php
class BaseDeDatos
{
    var $conexion;
    var $servidor;
    var $usuario;
    var $clave;
    var $baseDeDatos;
    var $bloq_registros;
    var $num_registros;
    function __construct()
    {
        // Para acceder a cualquier variable de la clase se usa $this->nombre_variable
        $this->servidor = 'localhost';
        $this->usuario = 'basta';
        $this->clave = '1234';
        $this->baseDeDatos = 'Basta';
    }

    function open()
    {
        $this->conexion = mysqli_connect($this->servidor, $this->usuario, $this->clave, $this->baseDeDatos);
    }

    function close()
    {
        mysqli_close($this->conexion);
    }

    function query($query)
    {
        $this->open();
        $this->bloq_registros = mysqli_query($this->conexion, $query);
        $this->num_registros = mysqli_num_rows($this->bloq_registros);
        $this->close();
    }
}

$oBD = new BaseDeDatos();