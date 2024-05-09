<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// TODO: AL AGREGAR JS ES NECESARIO ACTUALIZAR
// session_start();

include 'baseDeDatos.php';

class Categoria extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                $result = '<form class="p-40 flex" method="POST"><div class="container mt-4"> <h4 class="f-size-30">Agregar categoría</h4>';

                $result .= '<div class="flex align-center justify-content">
                    <label class="label col-md-4">Categoría</label>
                    <div class="col-md-8">
                    <input type="text" name="categoria" value="' . (isset($registro) ? $registro->categoria : "") . '" placeholder="Nombre" class="form-control">
                    </div>
                ';

                $result .= '<div>
                    <div class="col-md-8">
                    <input type="hidden" name="action" value="' . (!isset($registro) ? 'insert' : "update")  . '">
                    <input type="submit" value="' . (!isset($registro) ? "Actualizar" : "Registrar")  .  '">
                    </div>
                ';

                $result .= '</div> </form>';
                break;

            case 'formEdit':
                $registro = $this->getRecord("SELECT * FROM categoria WHERE id_categoria = " . $_POST['id_categoria']);

                $result = '
                <form class="p-40" method="POST"> 
                    <h4 class="f-size-30">Editar categoría</h4>
                    <input type="hidden" name="action" value="update">
                    <input name="id_categoria" value="' . $_POST['id_categoria'] . '" type="hidden">
                    <input name="categoria" value="' . $registro->categoria . '" class="mt-10 p-10">
                    <button class="p-10">Actualizar</button>
                    </form>
                ';
                break;
                // CRUD
            case 'insert':
                $this->query("INSERT INTO categoria (categoria) VALUES ('" . $_POST['categoria'] . "')");
                $result = $this->action('report');
                break;
            case 'report':
                $result = $this->despTablaDatos("SELECT * FROM categoria order by categoria");
                break;
            case 'delete':
                $this->query("DELETE FROM categoria WHERE id_categoria = " . $_POST['id_categoria']);
                $result = $this->action('report');
                break;
            case 'update':
                $this->query("UPDATE categoria SET categoria = '" . $_POST['categoria'] . "' WHERE id_categoria = " . $_POST['id_categoria']);
                $result = $this->action('report');
                break;
            default:
        }

        return $result;
    }

    function despTablaDatos($query)
    {
        $htmlStart = '<div class="flex column m-50">';
        $datos = '<table class="customTable center-text mt-50">';
        $this->query($query);
        $this->getRecord($query);

        $datos .= '
            <div class="flex space-between align-center gap-15">
                <h3 class="f-size-30">Categoría</h3> 
                <form method="post">
                    <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                    <input type="hidden" name="action" value="formNew">
                </form>
            </div>';

        // Fila de encabezados
        $datos .= '<thead><tr>';
        $campos = array("id","Categoría");
        foreach ($campos as $campo) {
            $datos .= '<th>' . $campo . '</th>';
        }
        $datos .= "<th>&nbsp</th><th>&nbsp</th>";
        $datos .= '</tr></thead>';

        // Contenido y datos
        $datos .= '<tbody>';
        foreach ($this->bloq_registros as $row) {
            $datos .= '<tr>';
            foreach ($row as $columna) {
                $datos .= '<td class="text-align-center">' . $columna . '</td>';
            }
            // Botón para borrar 
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-regular fa-trash-can"></i></button>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_categoria" value="' . $row['id_categoria'] . '">
                </form>
            </td>';
            // Botón para editar
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-solid fa-pen-to-square"></i></button> 
                    <input type="hidden" name="action" value="formEdit">
                    <input type="hidden" name="id_categoria" value="' . $row['id_categoria'] . '"> 
                </form>
            </td>';
            $datos .= "</tr>";
        }
        $datos .= '</tbody>';
        $datos .= '</table></div>';
        $htmlEnd = '</div>';
        echo ($htmlStart . $datos . $htmlEnd);
    }
}


$oCategoria = new Categoria();
if (isset($_REQUEST['action'])) echo $oCategoria->action($_REQUEST['action']);
else echo $oCategoria->action('report');
