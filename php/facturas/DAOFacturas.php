<?php

class DAOFacturas
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "gestion_de_citas");
    }

    public function getConenction()
    {
        return $this->conn;
    }

    public function obtenerDatosFactura($id_factura) {
        $id_factura = mysqli_real_escape_string($this->conn, $id_factura);

        $sql = "SELECT * FROM facturas WHERE id_factura = '$id_factura'";

        $resultado = $this->conn->query($sql);

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_assoc();
        }

        return null;
    }

    public function getCita()
    {
        $sql = "SELECT
            citas.id_cita,
            citas.fecha,
            citas.hora,
            citas.estado,
            CONCAT(doctor_persona.nombre, ' ', doctor_persona.apellido) AS nombre_doctor,
            CONCAT(paciente_persona.nombre, ' ', paciente_persona.apellido) AS nombre_paciente
        FROM
            citas
        JOIN
            doctor ON citas.id_doctor = doctor.id_doctor
        JOIN
            persona AS doctor_persona ON doctor.id_persona = doctor_persona.id_persona
        JOIN
            paciente ON citas.id_paciente = paciente.id_paciente
        JOIN
            persona AS paciente_persona ON paciente.id_persona = paciente_persona.id_persona
        WHERE
            citas.estado = 'Finalizada';
        ";

        $res = $this->conn->query($sql);

        $pacientes = "<select class='form-select' id='id_cita' name='id_cita' aria-label='Default select example'>"
            . "<option value=''>Seleccione un cita</option>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $selected = (isset($_GET['id_cita']) && $_GET['id_cita'] === $tupla["id_cita"]) ? 'selected' : '';
            $pacientes .= "<option value='" . $tupla["id_cita"] . "' $selected>" . $tupla["id_cita"] . " - " . $tupla["nombre_paciente"] . " - "  . $tupla["nombre_doctor"] . "</option>";
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

        $res = $this->conn->query($sql);

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

    public function getPaciente() {
        $sql = "SELECT
        Paciente.id_paciente,
        CONCAT(Persona_Paciente.nombre, ' ', Persona_Paciente.apellido) AS nombre_paciente
        FROM
            Paciente
            INNER JOIN persona AS Persona_Paciente ON Paciente.id_persona = Persona_Paciente.id_persona;";

        $res = $this->conn->query($sql);

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

    public function getTabla()
    {
        $sql = "SELECT
        doctor.id_doctor,
        paciente.id_paciente,
        CONCAT(doc_persona.nombre, ' ', doc_persona.apellido) AS nombre_doctor,
        CONCAT(pac_persona.nombre, ' ', pac_persona.apellido) AS nombre_paciente,
        facturas.*
        FROM
            facturas
            JOIN citas ON facturas.id_cita = citas.id_cita
            JOIN doctor ON citas.id_doctor = doctor.id_doctor
            JOIN persona doc_persona ON doctor.id_persona = doc_persona.id_persona
            JOIN paciente ON citas.id_paciente = paciente.id_paciente
            JOIN persona pac_persona ON paciente.id_persona = pac_persona.id_persona;";

        $res = $this->conn->query($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>Paciente</th>
                <th scope='col'>Medico</th>
                <th scope='col'>Monto total</th>
                <th scope='col'>Fecha emisión</th>
                <th scope='col'>tipo pago</th>
                <th scope='col'>Estado</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_factura"] . "</td>"
                . "<td>" . $tupla["nombre_paciente"] . "</td>"
                . "<td>" . $tupla["nombre_doctor"] . "</td>"
                . "<td>" . $tupla["monto_total"] . "</td>"
                . "<td>" . $tupla["fecha_Emision"] . "</td>"
                . "<td>" . $tupla["tipo_pago"] . "</td>"
                . "<td>" . $tupla["estado"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_factura"] . "\",\""
                . $tupla["id_cita"] . "\",\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["id_paciente"] . "\",\""
                . $tupla["monto_total"] . "\",\""
                . $tupla["fecha_Emision"] . "\",\""
                . $tupla["tipo_pago"] . "\",\""
                . $tupla["estado"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarFactura($objeto)
    {
        $fac = $objeto;
        $sql = "INSERT INTO facturas (id_cita, monto_total, fecha_Emision, tipo_pago, estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $id_cita = $fac->getIdCita();
            $monto_total = $fac->getMontoTotal();
            $fecha_Emision = $fac->getFechaEmision();
            $tipo_pago = $fac->getTipoPago();
            $estado = $fac->getEstado();

            $stmt->bind_param("iisss", $id_cita, $monto_total, $fecha_Emision, $tipo_pago, $estado);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Ingreso exitoso',text:'Se ha ingresado con éxito a la base de datos.', type: 'success'});</script>";
                $stmt->close();
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
                $stmt->close();
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido ingresar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function actualizarFactura($objeto)
    {
        $fac = $objeto;
        $sql = "UPDATE facturas SET id_cita = ?, monto_total = ?, fecha_Emision = ?, tipo_pago = ?, estado = ? WHERE id_factura = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $id_cita = $fac->getIdCita();
            $monto_total = $fac->getMontoTotal();
            $fecha_Emision = $fac->getFechaEmision();
            $tipo_pago = $fac->getTipoPago();
            $estado = $fac->getEstado();
            $id_factura = $fac->getIdFactura();

            $stmt->bind_param("iisssi", $id_cita, $monto_total, $fecha_Emision, $tipo_pago, $estado, $id_factura);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Actualización exitosa',text:'Se ha actualizado con éxito a la base de datos.', type: 'success'});</script>";
                $stmt->close();
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
                $stmt->close();
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido actualizar a la base de datos.', type: 'error'});</script>";
        }
    }

    public function eliminarFactura($objeto)
    {
        $fac = $objeto;

        $sql = "DELETE FROM facturas WHERE id_factura = ?";
        $sql2 = "DELETE FROM detalle_facturas WHERE id_factura = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt2 = $this->conn->prepare($sql2);

        if ($stmt && $stmt2) {
            $id_factura = $fac->getIdFactura();

            $stmt->bind_param("i", $id_factura);
            $stmt2->bind_param("i", $id_factura);

            if ($stmt->execute() && $stmt2->execute()) {
                echo "<script>swal({title:'Eliminación exitosa',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
                $stmt->close();
                $stmt2->close();
            } else {
                echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
                $stmt->close();
                $stmt2->close();
            }
        } else {
            echo "<script>swal({title:'Error',text:' No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
            $stmt->close();
            $stmt2->close();
        }
    }

    public function filtrarFactura($valor, $criterio)
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
