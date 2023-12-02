<?php

include '../../php/ConexionDB.php';

class DAOCitas
{

    private $conn;

    public function __construct()
    {
        $this->conn = new ConexionDB("localhost", "root", "", "gestion_de_citas");
    }

    public function getPacientes() {
        $sql = "SELECT
        Paciente.id_paciente,
        CONCAT(Persona_Paciente.nombre, ' ', Persona_Paciente.apellido) AS nombre_paciente
        FROM
            Paciente
            INNER JOIN Persona AS Persona_Paciente ON Paciente.id_persona = Persona_Paciente.id_persona;
        ";

        $res = $this->conn->hacerConsulta($sql);

        $pacientes = "<select class='form-select' id='id_paciente' name='id_paciente' aria-label='Default select example'>"
        . "<option value=''>Seleccione un paciente</option>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $selected = (isset($_GET['id_paciente']) && $_GET['id_paciente'] === $tupla["id_paciente"]) ? 'selected' : '';
            $pacientes .= "<option value='" . $tupla["id_paciente"] . "' $selected>" . $tupla["nombre_paciente"] . "</option>";
        }

        $pacientes .= "</select>";
        $res->close();
        return $pacientes;
    }

    public function getMedicos() {
        $sql = "SELECT
        Doctor.id_doctor,
        CONCAT(Persona_Doctor.nombre, ' ', Persona_Doctor.apellido) AS nombre_doctor
        FROM
            Doctor
            INNER JOIN persona AS Persona_Doctor ON Doctor.id_persona = Persona_Doctor.id_persona;
        ";

        $res = $this->conn->hacerConsulta($sql);

        $medicos = "<select class='form-select' id='id_doctor' name='id_doctor' aria-label='Default select example'>"
        . "<option value=''>Seleccione un medico</option>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $selected = (isset($_GET['id_doctor']) && $_GET['id_doctor'] === $tupla["id_doctor"]) ? 'selected' : '';
            $medicos .= "<option value='" . $tupla["id_doctor"] . "' $selected>" . $tupla["nombre_doctor"] . "</option>";
        }

        $medicos .= "</select>";
        $res->close();
        return $medicos;
    }

    public function getTabla()
    {
        $sql = "SELECT
        Citas.id_cita,
        Citas.fecha,
        Citas.hora,
        Citas.estado,
        Paciente.id_paciente,
        CONCAT(Persona_Paciente.nombre, ' ', Persona_Paciente.apellido) AS nombre_paciente,
        Doctor.id_doctor,
        Doctor.especialidad,
        CONCAT(Persona_Doctor.nombre, ' ', Persona_Doctor.apellido) AS nombre_doctor
        FROM
            citas
            INNER JOIN paciente ON Citas.id_paciente = Paciente.id_paciente
            INNER JOIN persona AS Persona_Paciente ON Paciente.id_persona = Persona_Paciente.id_persona
            INNER JOIN doctor ON Citas.id_doctor = Doctor.id_doctor
            INNER JOIN persona AS Persona_Doctor ON Doctor.id_persona = Persona_Doctor.id_persona;
        ";

        $res = $this->conn->hacerConsulta($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>Paciente</th>
                <th scope='col'>Medico</th>
                <th scope='col'>Especialidad</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Hora</th>
                <th scope='col'>Estado</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_cita"] . "</td>"
                . "<td>" . $tupla["nombre_paciente"] . "</td>"
                . "<td>" . $tupla["nombre_doctor"] . "</td>"
                . "<td>" . $tupla["especialidad"] . "</td>"
                . "<td>" . $tupla["fecha"] . "</td>"
                . "<td>" . $tupla["hora"] . "</td>"
                . "<td>" . $tupla["estado"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_cita"] . "\",\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["id_paciente"] . "\",\""
                . $tupla["fecha"] . "\",\""
                . $tupla["hora"] . "\",\""
                . $tupla["estado"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarCita($objeto)
    {
        $cit = $objeto;

        $sql = "INSERT INTO citas (id_paciente, id_doctor, fecha, hora, estado) VALUES (?,?,?,?,?)";

        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_paciente = $cit->getIdPaciente();
            $id_doctor = $cit->getIdMedico();
            $fecha = $cit->getFecha();
            $hora = $cit->getHora();
            $estado = $cit->getEstado();

            $stmt->bind_param("iisss", $id_paciente, $id_doctor, $fecha, $hora, $estado);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Ingreso exitoso',text:'Se ha ingresado con éxito a la base de datos.', type: 'success'});</script>";
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function actualizarCita($objeto)
    {
        $cit = $objeto;

        $sql = "UPDATE citas SET id_paciente = ?, id_doctor = ?, fecha = ?, hora = ?, estado = ? WHERE id_cita = ?";

        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_paciente = $cit->getIdPaciente();
            $id_doctor = $cit->getIdMedico();
            $fecha = $cit->getFecha();
            $hora = $cit->getHora();
            $estado = $cit->getEstado();
            $id_cita = $cit->getIdCita();

            $stmt->bind_param("iisssi", $id_paciente, $id_doctor, $fecha, $hora, $estado, $id_cita);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Actualización exitosa',text:'Se ha actualizado con éxito a la base de datos.', type: 'success'});</script>";
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function eliminarCita($objeto)
    {
        $cit = $objeto;

        $sql = "DELETE FROM citas WHERE id_cita = ?";
        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_cita = $cit->getIdCita();

            $stmt->bind_param("i", $id_cita);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Eliminación exitosa',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function filtrarCita($valor, $criterio)
    {
        $sql = "SELECT
        citas.id_cita,
        citas.fecha,
        citas.hora,
        citas.estado,
        paciente.id_paciente,
        CONCAT(Persona_Paciente.nombre, ' ', Persona_Paciente.apellido) AS nombre_paciente,
        doctor.id_doctor,
        doctor.especialidad,
        CONCAT(Persona_Doctor.nombre, ' ', Persona_Doctor.apellido) AS nombre_doctor
        FROM
            citas
            INNER JOIN paciente ON citas.id_paciente = Paciente.id_paciente
            INNER JOIN persona AS Persona_Paciente ON paciente.id_persona = Persona_Paciente.id_persona
            INNER JOIN doctor ON citas.id_doctor = doctor.id_doctor
            INNER JOIN persona AS Persona_Doctor ON doctor.id_persona = Persona_Doctor.id_persona
        where $criterio like '%$valor%';";

        $res = $this->conn->hacerConsulta($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>Paciente</th>
                <th scope='col'>Medico</th>
                <th scope='col'>Especialidad</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Hora</th>
                <th scope='col'>Estado</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_cita"] . "</td>"
                . "<td>" . $tupla["nombre_paciente"] . "</td>"
                . "<td>" . $tupla["nombre_doctor"] . "</td>"
                . "<td>" . $tupla["especialidad"] . "</td>"
                . "<td>" . $tupla["fecha"] . "</td>"
                . "<td>" . $tupla["hora"] . "</td>"
                . "<td>" . $tupla["estado"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_cita"] . "\",\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["id_paciente"] . "\",\""
                . $tupla["fecha"] . "\",\""
                . $tupla["hora"] . "\",\""
                . $tupla["estado"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }
}
