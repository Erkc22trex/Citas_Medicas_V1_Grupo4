<?php

include '../ConexionDB.php';

class DAOPersona
{
    private $conn;

    public function __construct()
    {
        $this->conn = new ConexionDB("localhost", "root", "", "gestion_de_citas");
    }

    public function getConexion()
    {
        return $this->conn;
    }

    public function existe($dni)
    {

        $sql = "select * from persona where dni = $dni";
        $filas = $this->conn->hacerConsulta($sql);

        if ($filas->num_rows) {
            $filas->close();
            return true;
        } else {
            $filas->close();
            return false;
        }
    }


    public function insertar($objeto)
    {
        $p = $objeto;

        if ($this->existe($p->getDni())) {
            echo "<script>swal({title:'Error',text:'Ya existe una persona con ese DNI.', type: 'error'});</script>";
        } else {
            $sql = "INSERT INTO persona (nombre, apellido, telefono, dni, edad, fecha_nacimiento, direccion, correo, sexo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare_query($sql);

            if ($stmt) {
                // Consulta de inserción con placeholders (?) "b", "d", "i", "s"
                $nombre = $p->getNombre();
                $apellido = $p->getApellido();
                $telefono = $p->getTelefono();
                $dni = $p->getDni();
                $edad = $p->getEdad();
                $fch_nac = $p->getFechaNacimiento();
                $direccion = $p->getDireccion();
                $correo = $p->getCorreo();
                $sexo = $p->getSexo();

                $stmt->bind_param(
                    "ssssissss",
                    $nombre,
                    $apellido,
                    $telefono,
                    $dni,
                    $edad,
                    $fch_nac,
                    $direccion,
                    $correo,
                    $sexo
                );

                if ($stmt->execute()) {
                    $id_persona_insertado = $this->conn->getConexion()->insert_id;
                    $stmt->close();
                    return $id_persona_insertado;
                } else {
                    $stmt->close();
                    return false;
                }
            }
        }
    }

    public function eliminar($dni)
    {
        if ($this->existe($dni)) {
            $sql = "DELETE FROM persona WHERE dni = ?";
            $stmt = $this->conn->prepare_query($sql);

            if ($stmt) {
                $stmt->bind_param("s", $dni);

                if ($stmt->execute()) {
                    echo "<script>swal({title:'Borrado exitoso',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
                    return true;
                } else {
                    echo "<script>swal({title:'Error',text:'No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
                    return false;
                }
            } else {
                echo "<script>swal({title:'Error',text:' No existe el paciente con ese código.', type: 'error'});</script>";
            }
        } else {
            //mensaje de error con sweet alert                   
            echo "<script>swal({title:'Error',text:' No existe una persona con ese código.', type: 'error'});</script>";
            return false;
        }
        return false;
    }

    public function actualizar($objeto)
    {
        $p = $objeto;
        if ($this->existe($p->getDni())) {
            $sql = "UPDATE persona SET nombre = '" . $p->getNombre() . "', apellido = '" . $p->getApellido()
                . "', telefono = '" . $p->getTelefono() . "', dni = '" . $p->getDni() . "', edad = '" . $p->getEdad()
                . "', fecha_nacimiento = '" . $p->getFechaNacimiento() . "', direccion = '" . $p->getDireccion()
                . "', correo = '" . $p->getCorreo() . "', sexo = '" . $p->getSexo()
                . "' WHERE id_persona = " . $p->getIdPersona();

            if ($this->conn->hacerConsulta($sql)) {
                return true;
            }
        }
        return false;
    }

}
