<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// TODO: AL AGREGAR JS ES NECESARIO ACTUALIZAR
// session_start();

include 'baseDeDatos.php';

class Torneo extends BaseDeDatos
{
    function action($cual)
    {
        $result = '';
        switch ($cual) {
            case 'formNew':
                $result = '<form class="p-40 flex" method="POST"><div class="container mt-4"> 
                <h4 class="f-size-30">Agregar torneo</h4>';

                $result .= '<div class="flex column gap-5">
                <div class="mt-20 flex space-between">
                <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" value="' . (isset($registro) ? $registro->fecha : "") . '" placeholder="Fecha">
                    </div>
                    <div class="flex space-between">
                    <label for="horaInicio">Hora de inicio</label>
                    <input type="text" name="horaInicio" value="' . (isset($registro) ? $registro->horaInicio : "") . '" placeholder="Hora de inicio">
                    </div>
                    <div class="flex space-between">
                    <label for="fechaLimite">Fecha Límite</label>
                    <input type="date" name="fechaLimite" value="' . (isset($registro) ? $registro->fechaLimite : "") . '" placeholder="Fecha límite">
                    </div>
                    <div class="flex space-between">
                <label for="numRondasMaximas">Número de Rondas máximas</label>
                <input type="number" name="numRondasMaximas" value="' . (isset($registro) ? $registro->numRondasMaximas : "") . '" placeholder="Número de rondas máximas">
                </div>
                <div class="flex space-between">
                <label for="tiemRonda">Tiempo de Ronda</label>
                    <input type="number" name="tiemRonda" value="' . (isset($registro) ? $registro->tiemRonda : "") . '" placeholder="Tiempo de Ronda">
                </div>
                <div class="flex space-between">
                <label for="puntosMeta">Puntos meta</label>
                <input type="number" name="puntosMeta" value="' . (isset($registro) ? $registro->puntosMeta : "") . '" placeholder="Puntos meta">
                </div>
                <div class="flex space-between">
                <label for="costo">Costo</label>
                <input type="number" name="costo" value="' . (isset($registro) ? $registro->costo : "") . '" placeholder="Costo">
                </div>
                <div class="flex space-between">
                <label for="premio">Premio</label>
                <input type="text" name="premio" value="' . (isset($registro) ? $registro->premio : "") . '" placeholder="Premio">
                </div>
';

                $result .= '<div class="flex end">
                    <div class="col-md-8">
                    <input type="hidden" name="action" value="' . (!isset($registro) ? 'insert' : "update")  . '">
                    <input class="ph-20 pv-10 bg-primary white-text no-border" type="submit" value="' . (!isset($registro) ? "Registrar" : "Actualizar")  .  '">
                    </div>
                ';

                $result .= '</div> </form>';
                break;

            case 'formEdit':
                // Obtener el registro a editar
                $registro = $this->getRecord("SELECT * FROM torneo WHERE id_torneo = " . $_POST['id_torneo']);

                // Formulario para editar el registro
                $result = '
                <form class="p-40" method="POST"> 
                    <h4 class="f-size-30">Editar torneo</h4>
                    <input type="hidden" name="action" value="update">
                    <input name="id_torneo" value="' . $_POST['id_torneo'] . '" type="hidden">
                    
                    <label for="fecha">Fecha:</label>
                    <input id="fecha" name="fecha" value="' . $registro->fecha . '" class="mt-10 p-10" placeholder="Fecha">
                    
                    <label for="horaInicio">Hora de Inicio:</label>
                    <input id="horaInicio" name="horaInicio" value="' . $registro->horaInicio . '" class="mt-10 p-10" placeholder="Hora de Inicio">
                    
                    <label for="fechaLimite">Fecha Límite:</label>
                    <input id="fechaLimite" name="fechaLimite" value="' . $registro->fechaLimite . '" class="mt-10 p-10" placeholder="Fecha Límite">
                    
                    <label for="numRondasMaximas">Número de Rondas Máximas:</label>
                    <input id="numRondasMaximas" name="numRondasMaximas" value="' . $registro->numRondasMaximas . '" class="mt-10 p-10" placeholder="Número de Rondas Máximas">
                    
                    <label for="tiemRonda">Tiempo por Ronda:</label>
                    <input id="tiemRonda" name="tiemRonda" value="' . $registro->tiemRonda . '" class="mt-10 p-10" placeholder="Tiempo por Ronda">
                    
                    <label for="puntosMeta">Puntos Meta:</label>
                    <input id="puntosMeta" name="puntosMeta" value="' . $registro->puntosMeta . '" class="mt-10 p-10" placeholder="Puntos Meta">
                    
                    <label for="costo">Costo:</label>
                    <input id="costo" name="costo" value="' . $registro->costo . '" class="mt-10 p-10" placeholder="Costo">
                    
                    <label for="premio">Premio:</label>
                    <input id="premio" name="premio" value="' . $registro->premio . '" class="mt-10 p-10" placeholder="Premio">
                    
                    <button class="p-10">Actualizar</button>
                </form>
                ';
                break;
                // CRUD
            case 'insert':
                $this->query("INSERT INTO torneo (fecha, horaInicio, fechaLimite, numRondasMaximas, tiemRonda, puntosMeta, costo, premio) VALUES ('" . $_POST['fecha'] . "', '" . $_POST['horaInicio'] . "', '" . $_POST['fechaLimite'] . "', " . $_POST['numRondasMaximas'] . ", " . $_POST['tiemRonda'] . ", " . $_POST['puntosMeta'] . ", " . $_POST['costo'] . ", '" . $_POST['premio'] . "') order by fecha desc");
                $result = $this->action('report');
                break;
            case 'report':
                $result = $this->despTablaDatos("SELECT * FROM torneo order by fecha desc");
                break;
            case 'delete':
                $this->query("DELETE FROM torneo WHERE id_torneo = " . $_POST['id_torneo']);
                $result = $this->action('report');
                break;
            case 'update':
                $this->query("UPDATE torneo SET 
    fecha = '" . $_POST['fecha'] . "',
    horaInicio = '" . $_POST['horaInicio'] . "',
    fechaLimite = '" . $_POST['fechaLimite'] . "',
    numRondasMaximas = " . $_POST['numRondasMaximas'] . ",
    tiemRonda = " . $_POST['tiemRonda'] . ",
    puntosMeta = " . $_POST['puntosMeta'] . ",
    costo = " . $_POST['costo'] . ",
    premio = '" . $_POST['premio'] . "'
WHERE id_torneo = " . $_POST['id_torneo']);

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
                <h3 class="f-size-30">Torneos</h3> 
                <form method="post">
                    <button class="p-10 radius-100 bg-primary white-text no-border"><i class="fa-solid fa-plus"></i></button>
                    <input type="hidden" name="action" value="formNew">
                </form>
            </div>';

        // Fila de encabezados
        $datos .= '<thead><tr class="white-text">';
        $campos = array("id", "Fecha", "Inicio", "Limite", "Rondas máximas", "Tiempo de ronda", "Puntos meta", "Costo", "Premio");
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
                $datos .= '<td>' . $columna . '</td>';
            }
            // Botón para borrar 
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-regular fa-trash-can"></i></button>
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id_torneo" value="' . $row['id_torneo'] . '">
                </form>
            </td>';
            // Botón para editar
            $datos .= '
            <td> 
                <form method="post">
                    <button><i class="fa-solid fa-pen-to-square"></i></button> 
                    <input type="hidden" name="action" value="formEdit">
                    <input type="hidden" name="id_torneo" value="' . $row['id_torneo'] . '"> 
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


$oTorneo = new Torneo();
if (isset($_REQUEST['action'])) echo $oTorneo->action($_REQUEST['action']);
else echo $oTorneo->action('report');
