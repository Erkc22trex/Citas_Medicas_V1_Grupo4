<?php

include '../personas/DAOpersona.php';

class DAORecepcionista
{

    private $DaoPer;

    public function __construct()
    {
        $this->DaoPer = new DAOPersona();
    }

    public function getTabla()
    {
        $sql = "SELECT * FROM recepcionista recp INNER JOIN persona per ON recp.id_persona = per.id_persona;";

        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

        $accion = "actualizar";

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>DNI</th>
                <th scope='col'>Nombre</th>
                <th scope='col'>Apellido</th>
                <th scope='col'>Telefono</th>
                <th scope='col'>Edad</th>
                <th scope='col'>Sexo</th>
                <th scope='col'>Fecha nacimiento</th>
                <th scope='col'>Correo</th>
                <th scope='col'>Direccion</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_recepcionista"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["nombre"] . "</td>"
                . "<td>" . $tupla["apellido"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fecha_nacimiento"] . "</td>"
                . "<td>" . $tupla["correo"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . 'actualizar' . "\",\""
                . $tupla["id_recepcionista"] . "\",\""
                . $tupla["id_persona"] . "\",\""
                . $tupla["dni"] . "\",\""
                . $tupla["nombre"] . "\",\""
                . $tupla["apellido"] . "\",\""
                . $tupla["telefono"] . "\",\""
                . $tupla["edad"] . "\",\""
                . $tupla["sexo"] . "\",\""
                . $tupla["fecha_nacimiento"] . "\",\""
                . $tupla["direccion"] . "\",\""
                . $tupla["correo"] . "\")'>Actualizar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarRecepcionista($objeto)
    {
        $id_persona = $this->DaoPer->insertar($objeto);

        if ($id_persona) {

            // Prepare and execute the second query
            $sql_query_pac = "INSERT INTO recepcionista (id_persona) VALUES (?)";
            $stmt_pac = $this->DaoPer->getConexion()->prepare_query($sql_query_pac);

            if ($stmt_pac) {
                $stmt_pac->bind_param("i", $id_persona);

                if ($stmt_pac->execute()) {
                    echo "<script>swal({title:'Inserción exitosa',text:'Se ha agregado con éxito a la base de datos.', icon: 'success', type: 'success'});</script>";
                    $stmt_pac->close();
                } else {
                    echo "<script>swal({title:'Error',text:'No se ha podido agregar a la base de datos.', icon: 'error', type: 'error'});</script>";
                    $stmt_pac->close();
                }
            } else {
                return "Hubo un error en la preparación de la segunda consulta: " . $this->DaoPer->getConexion()->error();
            }
        } else {
            return "Hubo un error en la preparación de la primera consulta: ";
        }
    }

    public function actualizarRecepcionista($objeto)
    {

        $resp = $this->DaoPer->actualizar($objeto);

        if ($resp) {
            //mensaje de éxito con sweet alert                             
            echo "<script>swal({title:'Actualización exitosa',text:'Datos actualizados correctamente.', type: 'success'});</script>";
        } else {
            //mensaje de error con sweet alert   
            echo "<script>swal({title:'Error',text:'No se ha podido actualizar la base de datos.', type: 'error'});</script>";
        }
    }

    public function eliminarRecepcionista($objeto)
    {
        $p = $objeto;

        $sql = "DELETE FROM recepcionista WHERE id_recepcionista = ?";
        $stmt = $this->DaoPer->getConexion()->prepare_query($sql);

        if ($stmt) {
            $id_recepcionista = $p->getIdRecepcionista();
            $stmt->bind_param("i", $id_recepcionista);

            if ($stmt->execute()) {
                $dni = $p->getDni();
                $this->DaoPer->eliminar($dni);
                echo "<script>swal({title:'Borrado exitoso',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
            } else {
                echo "<script>swal({title:'Error',text:' No existe el paciente con ese código.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No existe el paciente con ese código.', type: 'error'});</script>";
        }
    }

    public function filtrarPaciente($valor, $criterio)
    {
        // Cambiamos la consulta para buscar solo por DNI
        $sql = "SELECT * FROM persona WHERE dni = '$valor'";

        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

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
        return $tabla;
    }
}