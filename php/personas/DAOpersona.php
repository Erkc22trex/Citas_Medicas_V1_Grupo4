<?php

include '../ConexionDB.php';

class DAOPersona
{
    private $conn;

    public function __construct()
    {
        $this->conn = new ConexionDB("127.0.0.1", "admin", "1234", "gestion_de_citas");
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

    // public function filtrar($valor, $criterio)
    // {
    //     // Cambiamos la consulta para buscar solo por DNI
    //     $sql = "SELECT * FROM persona WHERE dni = '$valor'";

    //     $res = $this->conn->hacerConsulta($sql);

    //     // Resto del código para generar la tabla, manteniendo los elementos deseados en el while
    //     $tabla = "<table class='table table-dark'>"
    //         . "<thead class='thead thead-light'>"
    //         . "<tr><th>Primer Nombre</th><th>Segundo Nombre</th>"
    //         . "<th>Primer Apellido</th><th>Segundo Apellido</th><th>DNI</th>"
    //         . "<th>Telefono</th><th>Sexo</th><th>Fecha De Nacimiento</th>"
    //         . "<th>Edad</th><th>Direccion</th><th>Correo Electronico</th><th>Accion</th>"
    //         . "</tr></thead><tbody>";

    //     while ($tupla = mysqli_fetch_assoc($res)) {
    //         // Mantenemos solo las columnas necesarias (puedes agregar o quitar según lo necesites)
    //         $tabla .= "<tr>"
    //             . "<td>" . $tupla["primerNombre"] . "</td>"
    //             . "<td>" . $tupla["segundoNombre"] . "</td>"
    //             . "<td>" . $tupla["primerApellido"] . "</td>"
    //             . "<td>" . $tupla["segundoApellido"] . "</td>"
    //             . "<td>" . $tupla["dni"] . "</td>"
    //             . "<td>" . $tupla["telefono"] . "</td>"
    //             . "<td>" . $tupla["sexo"] . "</td>"
    //             . "<td>" . $tupla["fechaDeNacimiento"] . "</td>"
    //             . "<td>" . $tupla["edad"] . "</td>"
    //             . "<td>" . $tupla["direccion"] . "</td>"
    //             . "<td>" . $tupla["correoElectronico"] . "</td>"
    //             . "<td><a href=\"javascript:cargar('" . $tupla["primerNombre"]
    //             . "','" . $tupla["segundoNombre"] . "','" . $tupla["primerApellido"] . "','" . $tupla["segundoApellido"]
    //             . "','" . $tupla["dni"] . "','" . $tupla["telefono"] . "','" . $tupla["sexo"]
    //             . "','" . $tupla["fechaDeNacimiento"] . "','" . $tupla["edad"] . "','" . $tupla["direccion"]
    //             . "','" . $tupla["correoElectronico"]
    //             . "')\">Seleccionar</a></td>"
    //             . "</tr>";
    //     }

    //     $tabla .= "</tbody></table>";
    //     $res->close();
    //     $this->conn->cerrarConexion();
    //     return $tabla;
    // }
}
