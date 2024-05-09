<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// TODO: AL AGREGAR JS ES NECESARIO ACTUALIZAR
// session_start();

include 'baseDeDatos.php';

class Palabra extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                $result = '<form class="p-40 flex" method="POST"><div class="container mt-4"> <h4 class="f-size-30">Agregar palabra</h4>';

                $result .= '<div class="flex align-center justify-content gap-25">
                    <label class="label col-md-4">Palabra</label>
                    <div class="col-md-8">
                    <input type="text" name="palabra" value="' . (isset($registro) ? $registro->palabra : "") . '" placeholder="Palabra" class="form-control">
                    </div>
                ';

                $result .= '<div>
                    <div class="col-md-8">
                    <input type="hidden" name="action" value="' . (!isset($registro) ? 'insert' : "update")  . '">
                    <input type="submit" value="' . (!isset($registro) ? "Registrar" : "Actualizar")  .  '">
                    </div>
                ';

                $result .= '</div> </form>';
                break;

            case 'formEdit':
                $registro = $this->getRecord("SELECT * FROM palabra WHERE id_palabra = " . $_POST['id_palabra']);

                $result = '
                <form class="p-40" method="POST"> 
                    <h4 class="f-size-30">Editar palabra</h4>
                    <input type="hidden" name="action" value="update">
                    <input name="id_palabra" value="' . $_POST['id_palabra'] . '" type="hidden">
                    <input name="palabra" value="' . $registro->palabra . '" class="mt-10 p-10">
                    <button class="p-10">Actualizar</button>
                    </form>
                ';
                break;
                // CRUD
            case 'insert':
                $this->query("INSERT INTO palabra (palabra) VALUES ('" . $_POST['palabra'] . "')");
                $result = $this->action('report');
                break;
            case 'report':
                $result = $this->despTablaDatos("SELECT * FROM palabra order by palabra");
                break;
            case 'delete':
                $this->query("DELETE FROM palabra WHERE id_palabra = " . $_POST['id_palabra']);
                $result = $this->action('report');
                break;
            case 'update':
                $this->query("UPDATE palabra SET palabra = '" . $_POST['palabra'] . "' WHERE id_palabra = " . $_POST['id_palabra']);
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
                <h3 class="f-size-30">Palabras</h3> 
                <form method="post">
                    <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                    <input type="hidden" name="action" value="formNew">
                </form>
            </div>';

        // Fila de encabezados
        $datos .= '<thead><tr>';
        $campos = array("id", "Palabra");
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
                <form method="post" onsubmit="return confirm(\'¿Estás segur@ de que quieres borrar el registro: ' . $row['palabra'] . '?\')">
                    <button><i class="fa-regular fa-trash-can"></i></button>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_palabra" value="' . $row['id_palabra'] . '">
                </form>
            </td>';            
            // Botón para editar
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-solid fa-pen-to-square"></i></button> 
                    <input type="hidden" name="action" value="formEdit">
                    <input type="hidden" name="id_palabra" value="' . $row['palabra'] . '"> 
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


$oPalabra = new Palabra();
if (isset($_REQUEST['action'])) echo $oPalabra->action($_REQUEST['action']);
else echo $oPalabra->action('report');
