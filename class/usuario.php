<?php

/*
cuando se agregue js se modificaran las sesiones para no pasar p[or la vista
*/


//session_start();
include "baseDeDatos.php";
class Usuario extends BaseDeDatos
{
    function action($cual)
    {
        $result = "";
        switch ($cual) {
            case 'formEdit':
                $registro = $this->getRecord("SELECT * from usuario where id_usuario = " . $_REQUEST['id_usuario']);
            case 'formNew':
                $result .= "<div class='container-fluid d-flex align-items-center justify-content-center my-4'>
                <form method='post' onsubmit='return usuarios(\'insert\')' class='col-md-4 border border-dark border-3 p-3 mx-auto bg-info'>" .
                    (isset($registro) ? "<input type='hidden' name='id_usuario' value= '" . $_POST['id_usuario'] . "'>" : "")
                    . '<h1 class="text-dark">' . (isset($registro) ? "Actualizar" : "Agregar") . ' usuario</h1>';
                $result .= '
                    <div class="col-6 my-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <input type="email" required id="email" class="form-control border-dark bg-custom" name="email"
                        value="' . (isset($registro) ? $registro->email : "") . '">
                    </div>
                    </div>


                    <div class="col-6 my-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <div class="input-group">
                        <input type="text" required id="nombre" class="form-control border-dark bg-custom" name="nombre"
                        value="' . (isset($registro) ? $registro->nombre : "") . '">
                    </div>
                    </div>

                    <div class="col-6 my-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <div class="input-group">
                        <input type="text" required id="apellidos" class="form-control border-dark bg-custom" name="apellidos"
                        value="' . (isset($registro) ? $registro->apellidos : "") . '">
                    </div>
                    </div>

                    <div class="col-12 my-3">
                    <label for="clave" class="form-label">Clave</label>
                    <div class="input-group">
                        <input type="text" required id="clave" class="form-control border-dark bg-custom" name="clave" placeholder="la contraseña se cifrará">
                    </div>
                    </div>

                    <div class="col-12 my-3">
                    <label for="clave2" class="form-label">Re-Type Clave</label>
                    <div class="input-group">
                        <input type="text" required id="clave2" class="form-control border-dark bg-custom" name="clave2" placeholder="la contraseña se cifrará">
                    </div>
                    </div>


                    <div class="col-6 my-3">
                    <label for="genero" class="form-label">Genero</label>
                    <div class="input-group">

                        <select id="genero" name="genero" class="form-select border-dark bg-custom">
                            <option ' . (isset($registro) && $registro->genero == 'M' ? "selected" : "") . ' >Masculino</option>
                            <option ' . (isset($registro) && $registro->genero == 'F' ? "selected" : "") . ' >Fenemino</option>
                        </select>

                    </div>
                    </div>

                    <div class="col-6 my-3">
                    <label for="id_tipo_usuario" class="form-label">Tipo de usuario</label>
                    <div class="input-group">

                        <select id="id_tipo_usuario" name="id_tipo_usuario" class="form-select border-dark bg-custom">
                            <option ' . (isset($registro) && $registro->id_tipo_usuario == '1' ? "selected" : "") . ' value="1">Normal</option>
                            <option ' . (isset($registro) && $registro->id_tipo_usuario == '2' ? "selected" : "") . ' value="2">Admin</option>
                        </select>

                    </div>
                    </div>
                    ';


                $result .= '<div class="col-12 mb-1">
                        <input type="hidden" name="action" value="' . (isset($registro) ? "update" : "insert") . '">
                        <input type="submit" onclick="return usuarioss(\'valiForm\')" class="btn btn-dark text-white" value="' . (isset($registro) ? "Actualizar" : "Registrar") . '">
                        <span id="mensaje" class="badge bg-danger"></span>
                    </div>';


                $result .= '</form></div>';

                break;
            case 'insert':
                $this->query("INSERT into usuario set email = '" . $_POST['email'] . "', 
                                                            nombre = '" . $_POST['nombre'] . "', 
                                                            apellidos = '" . $_POST['apellidos'] . "', 
                                                            clave = password('" . $_POST['clave'] . "'), 
                                                            genero = '" . $_POST['genero'] . "', 
                                                            id_tipo_usuario = '" . $_POST['id_tipo_usuario'] . "'");
                $result = $this->action("report");
                break;
            case 'report':
                $result = $this->despTablaDatos("SELECT id_usuario, 
                                                               email, 
                                                               nombre, 
                                                               apellidos, 
                                                               genero, 
                                                               fechaUltiAcceso, 
                                                               tipo_usuario 
                                                            --    accesos 
                                                               from usuario order by email");
                break;
            case 'delete':
                $this->query("DELETE from usuario where id_usuario= " . $_POST['id_usuario']);
                $result = $this->action("report");
                break;
            case 'update':
                $this->query("UPDATE usuario set email = '" . $_POST['email'] . "', 
                                                       nombre = '" . $_POST['nombre'] . "', 
                                                       apellidos = '" . $_POST['apellidos'] . "', 
                                                       clave = password('" . $_POST['clave'] . "'), 
                                                       genero = '" . $_POST['genero'] . "', 
                                                       id_tipo_usuario = '" . $_POST['id_tipo_usuario'] . "' 
                                    where id_usuario= " . $_POST['id_usuario']);
                $result = $this->action("report");
                break;
        }
        return $result;
    }

    function despTablaDatos($query)
    {
        $html = "<div class='container mt-4 salsa-regular'>";
        $datos = '
        <div class="flex space-between align-center gap-15">
            <h3 class="f-size-30">Torneos</h3> 
                <button onclick="return usuario(\'formNew\')" class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
        </div>';
        $datos .= "<table class='table table-striped table hover fs-5'>";
        $this->query($query);
        //Cabecera
        $datos .= "<tr>";
        $campos = array();
        $datos .= "<td>&nbsp</td><td>&nbsp</td>";
        $tablaN = $this->campos($campos);
        foreach ($campos as $campo)
            $datos .= "<th classs='fs-4 center'>" . $campo . "</th>";
        $datos .= "</tr>";
        $header = "<div class='d-flex mb-2'>
        <span class='badge bg-info fs-4'>" . $tablaN . "</span>
        <form method='post' class='ms-2'><button class='btn btn-sm  btn-success fs-4'><i class='bi bi-plus'></i></button>
        <input type='hidden' name='action' value='formNew'></form></div>";
        //Termina la cabecera
        foreach ($this->bloq_registros as $row) {
            $datos .= "<tr>";

            $datos .= "<td class='col-1'>
            <button class='btn btn-sm btn-danger' onclick=\"usuario('delete', {$row['id_usuario']})\">
            <i class='fa-regular fa-trash-can'></i>
            </button>
       </td>";


            //     $datos .= "<td class='col-1'>
            //     <form method='post' onsubmit=\"return confirm('¿Estás seguro de borrar el registro: " . $row['email'] . "?')\">
            //         <button class='btn btn-sm btn-danger'>
            //             <i class='bi bi-trash'></i>
            //         </button>
            //         <input type='hidden' name='action' value='delete'>
            //         <input type='hidden' name='id_usuario' value='" . $row['id_usuario'] . "'>
            //     </form>
            //    </td>";


            $datos .= "<td class='col-1'>
            <button class='btn btn-sm btn-warning' onclick=\"usuario('formEdit', '{$row['id_usuario']}')\"><i class='fa-solid fa-pencil'></i></button>
          </td>";


            // $datos .= "<td class='col-1'><form method = 'post'><button class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></button>
            // <input type='hidden' name='action' value='formEdit'>
            // <input type='hidden' name='id_usuario' value='" . $row['id_usuario'] . "'></form></td>";
            foreach ($row as $dato)
                $datos .= "<td>$dato</td>";
            $datos .= "</tr>";
        }
        $datos .= "</table></div>";
        return $html . $header . $datos;
    }
}
//var_dump($_POST);

$oUsuario = new Usuario();
if (isset($_REQUEST['action']))
    echo $oUsuario->action($_REQUEST['action']);
else
    echo $oUsuario->action("report");
