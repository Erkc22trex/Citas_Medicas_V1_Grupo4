<?php

/**
 * Description of DAOPacientes
 *
 * @author joelv
 */
include '../personas/DAOpersona.php';

class DAOUsuario
{

    private $DaoPer;

    public function __construct()
    {
        $this->DaoPer = new DAOPersona();
    }

    public function getMedicos()
    {
        $sql = "SELECT 
        persona.id_persona,
        CONCAT(persona.nombre, ' ', persona.apellido) AS nombre_completo,
        doctor.id_doctor
        FROM persona
        INNER JOIN doctor ON persona.id_persona = doctor.id_persona;
        ";

        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

        $medicos = "<select class='form-select' id='id_doctor' name='id_doctor' aria-label='Default select example'>"
            . "<option value=''>Seleccione un medico</option>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $selected = (isset($_GET['id_persona']) && $_GET['id_persona'] === $tupla["id_persona"]) ? 'selected' : '';
            $medicos .= "<option value='" . $tupla["id_persona"] . "' $selected>" . $tupla["nombre_completo"] . "</option>";
        }

        $medicos .= "</select>";
        $res->close();
        return $medicos;
    }

    public function getRecepcionistas()
    {
        $sql = "SELECT 
        persona.id_persona,
        CONCAT(persona.nombre, ' ', persona.apellido) AS nombre_completo,
        recepcionista.id_recepcionista
        FROM persona
        INNER JOIN recepcionista ON persona.id_persona = recepcionista.id_persona;
        ";

        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

        $medicos = "<select class='form-select' id='id_recepcionista' name='id_recepcionista' aria-label='Default select example'>"
            . "<option value=''>Seleccione un recepcionista</option>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            $selected = (isset($_GET['id_persona']) && $_GET['id_persona'] === $tupla["id_persona"]) ? 'selected' : '';
            $medicos .= "<option value='" . $tupla["id_persona"] . "' $selected>" . $tupla["nombre_completo"] . "</option>";
        }

        $medicos .= "</select>";
        $res->close();
        return $medicos;
    }

    public function getTabla()
    {
        $sql = "SELECT * FROM usuario usr INNER JOIN persona per ON usr.id_persona = per.id_persona;";
        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

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
                <th scope='col'>Rol</th>
                <th scope='col'>Estado</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_usuario"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["nombre"] . "</td>"
                . "<td>" . $tupla["apellido"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fecha_nacimiento"] . "</td>"
                . "<td>" . $tupla["correo"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>" . $tupla["rol"] . "</td>"
                . "<td>" . $tupla["estado"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . 'actualizar' . "\",\""
                . $tupla["id_usuario"] . "\",\""
                . $tupla["id_persona"] . "\",\""
                . $tupla["dni"] . "\",\""
                . $tupla["nombre"] . "\",\""
                . $tupla["apellido"] . "\",\""
                . $tupla["telefono"] . "\",\""
                . $tupla["edad"] . "\",\""
                . $tupla["sexo"] . "\",\""
                . $tupla["fecha_nacimiento"] . "\",\""
                . $tupla["direccion"] . "\",\""
                . $tupla["correo"] . "\",\""
                . $tupla["rol"] . "\",\""
                . $tupla["estado"] . "\")'>Seleccionar</a>
                    </button>
                </td>"
                . "</tr>";
        }

        $tabla .= "</tbody></table>";
        $res->close();
        return $tabla;
    }

    public function ingresarUsuario($objeto)
    {
        $sql_query_pac = "INSERT INTO usuario (id_persona, rol, pass, estado) VALUES (?, ?, ?, ?)";
        $stmt_pac = $this->DaoPer->getConexion()->prepare_query($sql_query_pac);

        if ($stmt_pac) {
            $rol = $objeto->getRol();
            $pass = $objeto->getPassword();
            $estado = $objeto->getEstado();
            $id_persona = $objeto->getIdPersona();

            $stmt_pac->bind_param("isss", $id_persona, $rol, $pass, $estado);

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
    }

    public function actualizarUsuario($objeto)
    {
        $id_usuario = $objeto->getIdUsuario();
        $rol = $objeto->getRol();
        $pass = $objeto->getPassword();
        $estado = $objeto->getEstado();

        $sql = "UPDATE usuario SET rol = '" . $rol . "', estado = '" . $estado
            . "' WHERE id_usuario = " . $id_usuario;

        if ($this->DaoPer->getConexion()->hacerConsulta($sql)) {
            echo "<script>swal({title:'Actualización exitosa',text:'Datos actualizados correctamente.', type: 'success'});</script>";
        } else {
            echo "<script>swal({title:'Error',text:'No se ha podido actualizar los datos.', type: 'error'});</script>";
        }
    }

    public function login($objeto)
    {
        $correo = $objeto->getCorreo();
        $password = $objeto->getPassword();

        // Realiza la verificación en la base de datos (esquema básico)
        $sql = "SELECT u.*, p.*
        FROM usuario u
        INNER JOIN persona p ON u.id_persona = p.id_persona
        WHERE p.correo = ? AND u.pass = ?";

        $stmt = $this->DaoPer->getConexion()->prepare_query($sql);

        if ($stmt) {
            $stmt->bind_param("ss", $correo, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Crear un array con los datos que deseas enviar al cliente
                $response = array(
                    'correo' => $row['correo'],
                    'rol' => $row['rol'],
                    'id_persona' => $row['id_persona']
                );

                return $response;
            } else {
                return false;
            }
        } else {
            echo "Error en la consulta: " . $this->DaoPer->getConexion()->error();
            return false;
        }
    }

    public function eliminarUsuario($objeto)
    {
        $p = $objeto;

        $sql = "DELETE FROM usuario WHERE id_usuario = ?";
        $stmt = $this->DaoPer->getConexion()->prepare_query($sql);

        if ($stmt) {
            $id_usuario = $p->getIdUsuario();
            $stmt->bind_param("i", $id_usuario);

            if ($stmt->execute()) {
                echo "<script>swal({title:'Borrado exitoso',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
            } else {
                echo "<script>swal({title:'Error',text:' No existe el paciente con ese código.', type: 'error'});</script>";
            }
        } else {
            echo "<script>swal({title:'Error',text:' No existe el paciente con ese código.', type: 'error'});</script>";
        }
    }

    public function filtrarUsuario($valor, $criterio)
    {
        $sql = "SELECT * FROM usuario usr INNER JOIN persona per ON usr.id_persona = per.id_persona
        where $criterio like '%$valor%';";
        $res = $this->DaoPer->getConexion()->hacerConsulta($sql);

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
                <th scope='col'>Rol</th>
                <th scope='col'>Estado</th>
                <th scope='col'>Seleccionar</th>
            </tr>
        </thead><tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {

            $tabla .=
                "<tr>"
                . "<td>" . $tupla["id_usuario"] . "</td>"
                . "<td>" . $tupla["dni"] . "</td>"
                . "<td>" . $tupla["nombre"] . "</td>"
                . "<td>" . $tupla["apellido"] . "</td>"
                . "<td>" . $tupla["telefono"] . "</td>"
                . "<td>" . $tupla["edad"] . "</td>"
                . "<td>" . $tupla["sexo"] . "</td>"
                . "<td>" . $tupla["fecha_nacimiento"] . "</td>"
                . "<td>" . $tupla["correo"] . "</td>"
                . "<td>" . $tupla["direccion"] . "</td>"
                . "<td>" . $tupla["rol"] . "</td>"
                . "<td>" . $tupla["estado"] . "</td>"
                . "<td>
                    <button class='btn btn-success'>"
                . "<a href='javascript:void(0);' class='link-offset-2 link-underline link-underline-opacity-0 text-light' onclick='seleccionar(\""
                . 'actualizar' . "\",\""
                . $tupla["id_usuario"] . "\",\""
                . $tupla["id_persona"] . "\",\""
                . $tupla["dni"] . "\",\""
                . $tupla["nombre"] . "\",\""
                . $tupla["apellido"] . "\",\""
                . $tupla["telefono"] . "\",\""
                . $tupla["edad"] . "\",\""
                . $tupla["sexo"] . "\",\""
                . $tupla["fecha_nacimiento"] . "\",\""
                . $tupla["direccion"] . "\",\""
                . $tupla["correo"] . "\",\""
                . $tupla["rol"] . "\",\""
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
