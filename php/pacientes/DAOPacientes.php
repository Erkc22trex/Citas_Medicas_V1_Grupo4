<?php

/**
 * Description of DAOPacientes
 *
 * @author joelv
 */
include '../ConexionDB.php';

class DAOPacientes
{

    private $conn;

    public function __construct()
    {
        $this->conn = new ConexionDB("127.0.0.1", "admin", "1234", "gestion_de_citas");
    }

    public function getTabla()
    {
        $sql = "SELECT * FROM paciente pac INNER JOIN persona per ON pac.id_persona = per.id_persona;";

        $res = $this->conn->hacerConsulta($sql);

        $tabla = "<table class='table table-dark'><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $tabla .= "<tr>"
                . "<td>" . $tupla["id_persona"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["nombre"] . "</td>"
                . "<td>" . $tupla["apellido"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fecha_nacimiento"] . "</td>"
                . "<td>" . $tupla["correo"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>"
                . "<a href=\"javascript:cargar('"
                . $tupla["id_persona"] . "','"
                . $tupla["dni"] . "','"
                . $tupla["nombre"] . "','"
                . $tupla["telefono"] . "','"
                . $tupla["edad"] . "','"
                . $tupla["sexo"] . "','"
                . $tupla["fecha_nacimiento"] . "','"
                . $tupla["correo"] . "','"
                . "')\">Seleccionar</a></td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        $this->conn->cerrarConexion();
        return $tabla;
    }

    public function existe($objeto)
    {
        $p = $objeto;
        $sql = "SELECT * FROM tbl_pacientes WHERE Dni = ?";
        $stmt = $this->conn->hacerConsulta($sql);

        if ($stmt) {
            $dni = $p->getDni();
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $stmt->close();
                return true;
            } else {
                $stmt->close();
                return false;
            }
        } else {
            return "Hubo un error en la preparación de la consulta.";
        }
    }

    public function ingresarPaciente($objeto)
    {
        $p = $objeto;
        $this->conn = new ConexionDB("127.0.0.1", "admin", "1234", "gestion_de_citas");

        // Verificar si la persona ya existe antes de insertarla
        // if ($this->existe($p)) {
        //     return "La persona ya existe en la base de datos.";
        // }

        // Consulta de inserción con placeholders (?) "b", "d", "i", "s"
        $sql = "INSERT INTO persona (nombre, apellido, telefono, dni, edad, sexo, fecha_nacimiento, direccion, correo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare_query($sql);

        if ($stmt) {
            $nombre = $p->getNombre();
            $apellido = $p->getApellido();
            $telefono = $p->getTelefono();
            $dni = $p->getDni();
            $edad = $p->getEdad();
            $sexo = $p->getSexo();
            $fch_nac = $p->getFechaNacimiento();
            $direccion = $p->getDireccion();
            $correo = $p->getCorreo();

            // Enlazar parámetros
            $stmt->bind_param(
                "sssssssss",
                $nombre,
                $apellido,
                $dni,
                $telefono,
                $edad,
                $sexo,
                $fch_nac,
                $direccion,
                $correo
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Éxito
                $id_per = $stmt->insert_id;

                // Prepare and execute the second query
                $sql_query_pac = "INSERT INTO paciente (id_persona) VALUES (?)";
                $stmt_pac = $this->conn->prepare_query($sql_query_pac);

                if ($stmt_pac) {
                    $stmt_pac->bind_param("i", $id_per);

                    if ($stmt_pac->execute()) {
                        return $this->getTabla();
                    } else {
                        // Error al ejecutar la segunda consulta
                        return "No se ha podido agregar a la base de datos: " . $stmt_pac->error;
                    }
                } else {
                    // Error en la preparación de la segunda consulta
                    return "Hubo un error en la preparación de la segunda consulta: " . $this->conn->error();
                }
            } else {
                // Error al ejecutar la primera consulta
                return "No se ha podido agregar a la base de datos: " . $stmt->error;
            }
        } else {
            // Error en la preparación de la primera consulta
            return "Hubo un error en la preparación de la primera consulta: ";
        }
    }

    public function verPaciente($dni)
    {
        $sql = "SELECT * FROM pacientes WHERE Dni=?";
        $stmt = $this->conn->hacerConsulta($sql);

        if ($stmt) {
            $stmt->bind_param("s", $dni);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $personaInfo = $result->fetch_assoc();
                $stmt->close();
                return $personaInfo;
            } else {
                $stmt->close();
                return "La persona con DNI $dni no existe.";
            }
        } else {
            return "Hubo un error en la preparación de la consulta.";
        }
    }

    public function actualizarPaciente(Paciente $paciente)
    {
        //dni, nombre, telefono, citas, sexo, fch_nac, correo
        $sql = "UPDATE tbl_pacientes SET dni=?, nombre=?, telefono=?, citas=?, sexo=?, fch_nac=?, correo=? WHERE dni=?";
        $stmt = $this->conn->hacerConsulta($sql);

        if ($stmt) {
            $dni = $paciente->getDni();
            $nombre = $paciente->getNombre();
            $telefono = $paciente->getTelefono();
            $sexo = $paciente->getSexo();
            $fch_nac = $paciente->getFechaNacimiento();
            $correo = $paciente->getCorreo();

            $stmt->bind_param(
                "sssssss",
                $dni,
                $nombre,
                $telefono,
                $sexo,
                $fch_nac,
                $correo,
                $dni
            );

            if ($stmt->execute()) {
                return "Persona actualizada correctamente.";
            } else {
                return "Hubo un problema al actualizar la persona.";
            }
        } else {
            return "Hubo un error en la preparación de la consulta.";
        }
    }

    public function eliminarPaciente(Paciente $paciente)
    {
        $sql = "DELETE FROM tbl_pacientes WHERE dni=?";
        $dni = $paciente->getDni();
        $stmt = $this->conn->hacerConsulta($sql);

        if ($stmt) {
            $stmt->bind_param("s", $dni);

            if ($stmt->execute()) {
                return "Persona eliminada correctamente.";
            } else {
                return "Hubo un problema al eliminar la persona.";
            }
        } else {
            return "Hubo un error en la preparación de la consulta.";
        }
    }


    public function filtrarPaciente($valor, $criterio)
    {
        // Cambiamos la consulta para buscar solo por DNI
        $sql = "SELECT * FROM persona WHERE dni = '$valor'";

        $res = $this->conn->hacerConsulta($sql);

        // Resto del código para generar la tabla, manteniendo los elementos deseados en el while
        $tabla = "<table class='table table-dark'>"
            . "<thead class='thead thead-light'>"
            . "<tr><th>Primer Nombre</th><th>Segundo Nombre</th>"
            . "<th>Primer Apellido</th><th>Segundo Apellido</th><th>DNI</th>"
            . "<th>Telefono</th><th>Sexo</th><th>Fecha De Nacimiento</th>"
            . "<th>Edad</th><th>Direccion</th><th>Correo Electronico</th><th>Accion</th>"
            . "</tr></thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            // Mantenemos solo las columnas necesarias (puedes agregar o quitar según lo necesites)
            $tabla .= "<tr>"
                . "<td>" . $tupla["primerNombre"] . "</td>"
                . "<td>" . $tupla["segundoNombre"] . "</td>"
                . "<td>" . $tupla["primerApellido"] . "</td>"
                . "<td>" . $tupla["segundoApellido"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fechaDeNacimiento"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>" . $tupla["correoElectronico"] . "</td>"
                . "<td><a href=\"javascript:cargar('" . $tupla["primerNombre"]
                . "','" . $tupla["segundoNombre"] . "','" . $tupla["primerApellido"] . "','" . $tupla["segundoApellido"]
                . "','" . $tupla["dni"] . "','" . $tupla["telefono"] . "','" . $tupla["sexo"]
                . "','" . $tupla["fechaDeNacimiento"] . "','" . $tupla["edad"] . "','" . $tupla["direccion"]
                . "','" . $tupla["correoElectronico"]
                . "')\">Seleccionar</a></td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        $this->conn->cerrarConexion();
        return $tabla;
    }
}
