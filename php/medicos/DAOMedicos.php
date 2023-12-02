<?php

include '../personas/DAOpersona.php';

class DAOMedicos
{

    private $DaoPer;

    public function __construct()
    {
        $this->DaoPer = new DAOPersona();
    }

    public function getTabla()
    {
        $sql = "SELECT * FROM doctor doc INNER JOIN persona per ON doc.id_persona = per.id_persona;";

        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>DNI</th>
                <th scope='col'>Nombre</th>
                <th scope='col'>Apellido</th>
                <th scope='col'>Especialidad</th>
                <th scope='col'>Telefono</th>
                <th scope='col'>Edad</th>
                <th scope='col'>Sexo</th>
                <th scope='col'>Fecha nacimiento</th>
                <th scope='col'>Correo</th>
                <th scope='col'>Direccion</th>
                <th scope='col'>Seleccionar medico</th>
                <th scope='col'>Seleccionar Itinerario</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_doctor"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["nombre"] . "</td>"
                . "<td>" . $tupla["apellido"] . "</td>"
                . "<td>" . $tupla["especialidad"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fecha_nacimiento"] . "</td>"
                . "<td>" . $tupla["correo"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["id_persona"] . "\",\""
                . $tupla["dni"] . "\",\""
                . $tupla["nombre"] . "\",\""
                . $tupla["apellido"] . "\",\""
                . $tupla["especialidad"] . "\",\""
                . $tupla["telefono"] . "\",\""
                . $tupla["edad"] . "\",\""
                . $tupla["sexo"] . "\",\""
                . $tupla["fecha_nacimiento"] . "\",\""
                . $tupla["direccion"] . "\",\""
                . $tupla["correo"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionarItinerario(\""
                . $tupla["id_doctor"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarMedico($objeto)
    {
        $id_persona = $this->DaoPer->insertar($objeto);

        if ($id_persona) {

            $sql_query_pac = "INSERT INTO doctor (id_persona, especialidad) VALUES (?, ?)";
            $stmt_pac = $this->DaoPer->getConexion()->prepare_query($sql_query_pac);

            if ($stmt_pac) {
                $especialidad = $objeto->getEspecialidad();
                $stmt_pac->bind_param("is", $id_persona, $especialidad);

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

    public function actualizarMedico($objeto)
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

    public function eliminarMedico($objeto)
    {
        $p = $objeto;

        $sql = "DELETE FROM doctor WHERE id_doctor = ?";
        $stmt = $this->DaoPer->getConexion()->prepare_query($sql);

        if ($stmt) {
            $id_medico = $p->getIdMedico();
            $stmt->bind_param("i", $id_medico);

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
        $sql = "SELECT * FROM doctor doc INNER JOIN persona per ON doc.id_persona = per.id_persona
        where $criterio like '%$valor%';";

        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

        $tabla = "<table class='table table-dark'>
        <thead>
            <tr>
                <th scope='col'>Codigo</th>
                <th scope='col'>DNI</th>
                <th scope='col'>Nombre</th>
                <th scope='col'>Apellido</th>
                <th scope='col'>Especialidad</th>
                <th scope='col'>Telefono</th>
                <th scope='col'>Edad</th>
                <th scope='col'>Sexo</th>
                <th scope='col'>Fecha nacimiento</th>
                <th scope='col'>Correo</th>
                <th scope='col'>Direccion</th>
                <th scope='col'>Seleccionar medico</th>
                <th scope='col'>Seleccionar Itinerario</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_doctor"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["nombre"] . "</td>"
                . "<td>" . $tupla["apellido"] . "</td>"
                . "<td>" . $tupla["especialidad"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fecha_nacimiento"] . "</td>"
                . "<td>" . $tupla["correo"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . $tupla["id_doctor"] . "\",\""
                . $tupla["id_persona"] . "\",\""
                . $tupla["dni"] . "\",\""
                . $tupla["nombre"] . "\",\""
                . $tupla["apellido"] . "\",\""
                . $tupla["especialidad"] . "\",\""
                . $tupla["telefono"] . "\",\""
                . $tupla["edad"] . "\",\""
                . $tupla["sexo"] . "\",\""
                . $tupla["fecha_nacimiento"] . "\",\""
                . $tupla["direccion"] . "\",\""
                . $tupla["correo"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionarItinerario(\""
                . $tupla["id_doctor"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }
}
