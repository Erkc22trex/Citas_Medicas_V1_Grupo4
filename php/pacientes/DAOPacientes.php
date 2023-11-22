<?php

/**
 * Description of DAOPacientes
 *
 * @author joelv
 */
class DAOPacientes {

    private $conn;

    public function __construct() {
        $this->conectar();
    }

    public function conectar() {
        $this->conn = new mysqli("127.0.0.1", "admin", "1234", "crud_pacientes_mysql");

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }

    public function desconectar() {
        $this->conn->close();
    }

    public function getTabla() {
        $sql = "SELECT * FROM tbl_pacientes";
        $this->conectar();
        $res = $this->conn->query($sql);// res: response
        
        $tabla = "<table class='table table-dark'><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {
             $tabla .= "<tr>"
                    ."<td>".$tupla["id"]."</td>"
                    ."<td>".$tupla["dni"]."</td>"
                    ."<td>".$tupla["nombre"]."</td>"
                    ."<td>".$tupla["telefono"]."</td>"
                    ."<td>".$tupla["citas"]."</td>"
                    ."<td>".$tupla["sexo"]."</td>"
                    ."<td>".$tupla["fch_nac"]."</td>"
                    ."<td>".$tupla["correo"]."</td>"
                    ."<td>"
                    ."<a href=\"javascript:cargar('"
                    .$tupla["id"]."','"
                    .$tupla["dni"]."','"
                    .$tupla["nombre"]."','"
                    .$tupla["telefono"]."','"
                    .$tupla["citas"]."','"
                    .$tupla["sexo"]."','"
                    .$tupla["fch_nac"]."','"
                    .$tupla["correo"]."','"
                    ."')\">Seleccionar</a></td>" 
                    ."</tr>";  
        }

        $tabla .= "</tbody></table>";
        $res->close();
        $this->desconectar();
        return $tabla;
    }

    public function existe($objeto) {
        $p = $objeto;
        $sql = "SELECT * FROM tbl_pacientes WHERE Dni = ?";
        $stmt = $this->conn->prepare($sql);

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

    public function ingresarPaciente($objeto) {
        $p = $objeto;

        // Verificar si la persona ya existe antes de insertarla
        if ($this->existe($p)) {
            return "La persona ya existe en la base de datos.";
        }

        // Consulta de inserción con placeholders (?) "b", "d", "i", "s"
        $sql = "INSERT INTO tbl_pacientes (dni, nombre, telefono, citas, sexo, fch_nac, correo) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $dni = $p->getDni();
            $nombre = $p->getNombre();
            $telefono = $p->getTelefono();
            $citas = $p->getCitas();
            $sexo = $p->getSexo();
            $fch_nac = $p->getFchNac();
            $correo = $p->getCorreo();

            // Enlazar parámetros
            $stmt->bind_param("sssssss",
                    $dni,
                    $nombre,
                    $telefono,
                    $citas,
                    $sexo,
                    $fch_nac,
                    $correo
            );

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Éxito
                return $this->getTabla();
            } else {
                // Error al ejecutar la consulta
                return "No se ha podido agregar a la base de datos: " . $stmt->error;
            }
        } else {
            // Error en la preparación de la consulta
            return "Hubo un error en la preparación de la consulta: " . $this->conn->error;
        }
    }

    public function verPaciente($dni) {
        $sql = "SELECT * FROM tbl_pacientes WHERE Dni=?";
        $stmt = $this->conn->prepare($sql);

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

    public function actualizarPaciente(Paciente $paciente) {
        //dni, nombre, telefono, citas, sexo, fch_nac, correo
        $sql = "UPDATE tbl_pacientes SET dni=?, nombre=?, telefono=?, citas=?, sexo=?, fch_nac=?, correo=? WHERE dni=?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt) {
            $dni = $paciente->getDni();
            $nombre = $paciente->getNombre();
            $telefono = $paciente->getTelefono();
            $citas = $paciente->getCitas();
            $sexo = $paciente->getSexo();
            $fch_nac = $paciente->getFchNac();
            $correo = $paciente->getCorreo();

            $stmt->bind_param("ssssssss",
                    $dni,
                    $nombre,
                    $telefono,
                    $citas,
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

    public function eliminarPaciente(Paciente $paciente) {
        $sql = "DELETE FROM tbl_pacientes WHERE dni=?";
        $dni = $paciente->getDni();
        $stmt = $this->conn->prepare($sql);

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
}
