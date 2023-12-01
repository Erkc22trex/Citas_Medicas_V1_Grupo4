<?php

include '../../php/ConexionDB.php';

class DAOExpedientes
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
            paciente
            INNER JOIN persona AS Persona_Paciente ON Paciente.id_persona = Persona_Paciente.id_persona;
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
            doctor
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
        CONCAT(doc_persona.nombre, ' ', doc_persona.apellido) AS nombre_doctor,
        CONCAT(pac_persona.nombre, ' ', pac_persona.apellido) AS nombre_paciente,
        ep.*
        FROM
            expedientes_pacientes ep
            JOIN doctor d ON ep.id_doctor = d.id_doctor
            JOIN persona doc_persona ON d.id_persona = doc_persona.id_persona
            JOIN paciente p ON ep.id_paciente = p.id_paciente
            JOIN persona pac_persona ON p.id_persona = pac_persona.id_persona;
        ";

        $res = $this->conn->hacerConsulta($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>Doctor</th>
                <th scope='col'>Paciente</th>
                <th scope='col'>Diagnostico</th>
                <th scope='col'>tratamiento</th>
                <th scope='col'>observaciones</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_expediente"] . "</td>"
                . "<td>" . $tupla["nombre_doctor"] . "</td>"
                . "<td>" . $tupla["nombre_paciente"] . "</td>"
                . "<td>" . $tupla["diagnostico"] . "</td>"
                . "<td>" . $tupla["tratamiento"] . "</td>"
                . "<td>" . $tupla["observaciones"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_expediente"] . "\",\""
                . $tupla["id_paciente"] . "\",\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["diagnostico"] . "\",\""
                . $tupla["tratamiento"] . "\",\""
                . $tupla["observaciones"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarExpediente($objeto)
    {
        $exp = $objeto;

        $sql = "INSERT INTO expedientes_pacientes (id_paciente, id_doctor, diagnostico, tratamiento, observaciones) VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_paciente = $exp->getIdPaciente();
            $id_doctor = $exp->getIdMedico();
            $diagnostico = $exp->getDianostico();
            $tratamiento = $exp->getTratamiento();
            $observaciones = $exp->getObservaciones();

            $stmt->bind_param("iisss", $id_paciente, $id_doctor, $diagnostico, $tratamiento, $observaciones);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Inserción exitosa',text:'Se ha agregado con éxito a la base de datos.', icon: 'success', type: 'success'});</script>";
                $stmt->close();
            } else {
                echo "<script>swal({title:'Error',text:'No se ha podido agregar a la base de datos.', icon: 'error', type: 'error'});</script>";
                $stmt->close();
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
            $stmt->close();
        }
    }

    public function actualizarExpediente($objeto)
    {
        $exp = $objeto;

        $sql = "UPDATE expedientes_pacientes SET id_paciente = ?, id_doctor = ?, diagnostico = ?, tratamiento = ?, observaciones = ? WHERE id_expediente = ?";
        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_expediente = $exp->getIdExpediente();
            $id_paciente = $exp->getIdPaciente();
            $id_doctor = $exp->getIdMedico();
            $diagnostico = $exp->getDianostico();
            $tratamiento = $exp->getTratamiento();
            $observaciones = $exp->getObservaciones();

            $stmt->bind_param("iisssi", $id_paciente, $id_doctor, $diagnostico, $tratamiento, $observaciones, $id_expediente);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Actualización exitosa',text:'Se ha actualizado con éxito a la base de datos.', type: 'success'});</script>";
                $stmt->close();
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
                $stmt->close();
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
            $stmt->close();
        }

    }

    public function eliminarExpediente($objeto)
    {
        $exp = $objeto;

        $sql = "DELETE FROM expedientes_pacientes WHERE id_expediente = ?";

        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $id_expediente = $exp->getIdExpediente();

            $stmt->bind_param("i", $id_expediente);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Eliminación exitosa',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
                $stmt->close();
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
                $stmt->close();
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
            $stmt->close();
        }
    }

    public function filtrarExpediente($valor, $criterio)
    {
        // Cambiamos la consulta para buscar solo por DNI
        // $sql = "SELECT * FROM persona WHERE dni = '$valor'";

        // $res = $this->conn->getConexion()->hacerConsulta($sql);

        // // Resto del código para generar la tabla, manteniendo los elementos deseados en el while
        // $tabla = "<table class='table table-dark'>"
        //     . "<thead class='thead thead-light'>"
        //     . "<tr><th>Primer Nombre</th><th>Segundo Nombre</th>"
        //     . "<th>Primer Apellido</th><th>Segundo Apellido</th><th>DNI</th>"
        //     . "<th>Telefono</th><th>Sexo</th><th>Fecha De Nacimiento</th>"
        //     . "<th>Edad</th><th>Direccion</th><th>Correo Electronico</th><th>Accion</th>"
        //     . "</tr></thead><tbody>";

        // while ($tupla = mysqli_fetch_assoc($res)) {
        //     // Mantenemos solo las columnas necesarias (puedes agregar o quitar según lo necesites)
        //     $tabla .= "<tr>"
        //         . "<td>" . $tupla["primerNombre"] . "</td>"
        //         . "<td>" . $tupla["segundoNombre"] . "</td>"
        //         . "<td>" . $tupla["primerApellido"] . "</td>"
        //         . "<td>" . $tupla["segundoApellido"] . "</td>"
        //         . "<td>" . $tupla["dni"] . "</td>"
        //         . "<td>" . $tupla["telefono"] . "</td>"
        //         . "<td>" . $tupla["sexo"] . "</td>"
        //         . "<td>" . $tupla["fechaDeNacimiento"] . "</td>"
        //         . "<td>" . $tupla["edad"] . "</td>"
        //         . "<td>" . $tupla["direccion"] . "</td>"
        //         . "<td>" . $tupla["correoElectronico"] . "</td>"
        //         . "<td><a href=\"javascript:cargar('" . $tupla["primerNombre"]
        //         . "','" . $tupla["segundoNombre"] . "','" . $tupla["primerApellido"] . "','" . $tupla["segundoApellido"]
        //         . "','" . $tupla["dni"] . "','" . $tupla["telefono"] . "','" . $tupla["sexo"]
        //         . "','" . $tupla["fechaDeNacimiento"] . "','" . $tupla["edad"] . "','" . $tupla["direccion"]
        //         . "','" . $tupla["correoElectronico"]
        //         . "')\">Seleccionar</a></td>"
        //         . "</tr>";
        // }

        // $tabla .= "</tbody></table>";
        // $res->close();
        // return $tabla;
    }
}
