<?php

include '../../../php/ConexionDB.php';

class DAOItinerarios
{

    private $conn;

    public function __construct()
    {
        $this->conn = new ConexionDB("localhost", "root", "", "gestion_de_citas");
    }

    public function getMedicos()
    {
        $sql = "SELECT
        Doctor.id_doctor as id_medico,
        CONCAT(Persona_Doctor.nombre, ' ', Persona_Doctor.apellido) AS nombre_medico
        FROM
            doctor
            INNER JOIN persona AS Persona_Doctor ON Doctor.id_persona = Persona_Doctor.id_persona;";

        $res = $this->conn->hacerConsulta($sql);

        $medicos = "<select class='form-select' id='id_medico' name='id_medico' disabled aria-label='Default select example'>"
            . "<option value=''>Seleccione un medico</option>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $selected = (isset($_GET['id_medico']) && $_GET['id_medico'] === $tupla["id_medico"]) ? 'selected' : '';
            $medicos .= "<option value='" . $tupla["id_medico"] . "' $selected>" . $tupla["nombre_medico"] . "</option>";
        }

        $medicos .= "</select>";
        $res->close();
        return $medicos;
    }

    public function getTabla()
    {
        $id_medico = isset($_GET['id_medico']) ? $_GET['id_medico'] : '';

        $sql = "SELECT
        CONCAT(doc_persona.nombre, ' ', doc_persona.apellido) AS nombre_doctor,
        it.*
        FROM
            itinerario it
            JOIN doctor d ON it.id_doctor = d.id_doctor
            JOIN persona doc_persona ON d.id_persona = doc_persona.id_persona
        WHERE it.id_doctor = ?";

        $stmt = $this->conn->prepare_query($sql);
        if ($stmt) {
            $stmt->bind_param("i", $id_medico);
            $stmt->execute();
            $res = $stmt->get_result();
        }

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Código</th>
                <th scope='col'>Medico</th>
                <th scope='col'>Hora entrada</th>
                <th scope='col'>Hora salida</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_itinerario"] . "</td>"
                . "<td>" . $tupla["nombre_doctor"] . "</td>"
                . "<td>" . $tupla["hora_entrada"] . "</td>"
                . "<td>" . $tupla["hora_salida"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_itinerario"] . "\",\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["hora_entrada"] . "\",\""
                . $tupla["hora_salida"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarItinerario($objeto)
    {
        $itn = $objeto;

        $sql = "INSERT INTO itinerario (id_doctor, hora_entrada, hora_salida) VALUES (?,?,?)";

        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_medico = $itn->getIdMedico();
            $horaEntrada = $itn->getHoraEntrada();
            $horaSalida = $itn->getHoraSalida();
            $stmt->bind_param("iss", $id_medico, $horaEntrada, $horaSalida);

            if ($stmt->execute()) {
                echo "<script>
                    window.location.href = './TablaItinerarios.php?id_medico=' + $id_medico;
                </script>";
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function actualizarItinerario($objeto)
    {
        $itn = $objeto;

        $sql = "UPDATE itinerario SET id_doctor = ?, hora_entrada = ?, hora_salida = ? WHERE id_itinerario = ?";
        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_medico = $itn->getIdMedico();
            $horaEntrada = $itn->getHoraEntrada();
            $horaSalida = $itn->getHoraSalida();
            $id_itinerario = $itn->getIdItinerario();
            $stmt->bind_param("issi", $id_medico, $horaEntrada, $horaSalida, $id_itinerario);

            if ($stmt->execute()) {
                echo "<script>
                    window.location.href = './TablaItinerarios.php?id_medico=' + $id_medico;
                </script>";
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function eliminarItinerario($objeto)
    {
        $itn = $objeto;

        $sql = "DELETE FROM itinerario WHERE id_itinerario = ?";
        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_itinerario = $itn->getIdItinerario();
            $stmt->bind_param("i", $id_itinerario);

            if ($stmt->execute()) {
                $id_medico = $itn->getIdMedico();
                echo "<script>
                    window.location.href = './TablaItinerarios.php?id_medico=' + $id_medico;
                </script>";
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
        }
    }

}
