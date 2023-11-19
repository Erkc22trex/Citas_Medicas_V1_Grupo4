<?php
include 'Persona.php';
include 'informacion.php';
class DAOpersona {
   private $conn;
    public function __construct() {
        $this->conectar();
        }
    public function conectar() {
        $this->conn = new mysqli(SERVIDOR, USUARIO, CLAVES, BD);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }
    }
        //desconectar de la base de datos
    public function desconectar() {
        $this->conn->close;}
        
        public function getTabla() {
    $sql = "SELECT * FROM persona"; // Consulta SQL para obtener todas las personas
    $this->conectar(); // Conexión a la base de datos
    $res = $this->conn->query($sql); // Almacenar el resultado de la consulta

    // Creación de la tabla HTML
    $tabla = "<table class='table table-dark'>
                <thead class='thead thead-light'>
                    <tr>
                        <th>Primer Nombre</th>
                        <th>Segundo Nombre</th>
                        <th>Primer Apellido</th>
                        <th>Segundo Apellido</th>
                        <th>DNI</th>
                        <th>Telefono</th>
                        <th>Sexo</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Edad</th>
                        <th>Direccion</th>
                        <th>Correo Electrónico</th>
                        <!-- Agrega más columnas si es necesario para mostrar la información -->
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>";

    // Construcción del cuerpo de la tabla con los datos de la base de datos
    while ($tupla = mysqli_fetch_assoc($res)) {
        $tabla .= "<tr>
                    <td>".$tupla["Primer_Nombre"]."</td>
                    <td>".$tupla["Segundo_Nombre"]."</td>
                    <td>".$tupla["Primer_Apellido"]."</td>
                    <td>".$tupla["Segundo_Apellido"]."</td>
                    <td>".$tupla["Dni"]."</td>
                    <td>".$tupla["Telefono"]."</td>
                    <td>".$tupla["Sexo"]."</td>
                    <td>".$tupla["Fecha_de_nacimiento"]."</td>
                    <td>".$tupla["Edad"]."</td>
                    <td>".$tupla["Direccion"]."</td>
                    <td>".$tupla["Correo_Electronico"]."</td>
                    <!-- Agrega más celdas si hay más columnas -->
                    <td><a href=\"actualizar.php?dni=".$tupla["Dni"]."\">Actualizar</a> | 
                    <a href=\"eliminar.php?dni=".$tupla["Dni"]."\">Eliminar</a></td>
                </tr>";
    }

    $tabla .= "</tbody></table>"; // Cierre de la tabla
    $res->close(); // Cierre del resultado
    $this->desconectar(); // Cierre de la conexión
    return $tabla; // Retorno de la tabla HTML
}
    public function existe($objeto) {
    $p = $objeto;
    $sql = "SELECT * FROM persona WHERE Dni = ?";
    $stmt = $this->conn->prepare($sql);

    if ($stmt) {
        $dni = $p->getDni();
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // La persona existe
            $stmt->close();
            return true;
        } else {
            // La persona no existe
            $stmt->close();
            return false;
        }
    } else {
        // Error en la preparación de la consulta
        return "Hubo un error en la preparación de la consulta.";
    }
}

    public function ingresarPersona($objeto) {
    $p = $objeto;

    // Verificar si la persona ya existe antes de insertarla
    if ($this->existe($p)) {
        return "La persona ya existe en la base de datos.";
    }

    // Consulta de inserción con placeholders (?)
    $sql = "INSERT INTO persona (Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Dni, Telefono, Sexo, Fecha_de_nacimiento, Edad, Direccion, Correo_Electronico) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);

    if ($stmt) {
        $primerNombre = $p->getPrimerNombre();
        $segundoNombre = $p->getSegundoNombre();
        $primerApellido = $p->getPrimerApellido();
        $segundoApellido = $p->getSegundoApellido();
        $dni = $p->getDni();
        $telefono = $p->getTelefono();
        $sexo = $p->getSexo();
        $fechaDeNacimiento = $p->getFechaDeNacimiento();
        $edad = $p->getEdad();
        $direccion = $p->getDireccion();
        $correoElectronico = $p->getCorreoElectronico();

        // Enlazar parámetros
        $stmt->bind_param("ssssisssiss",
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $dni,
            $telefono,
            $sexo,
            $fechaDeNacimiento,
            $edad,
            $direccion,
            $correoElectronico
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

    // Método para ver información de una persona por su DNI
    public function verPersona($dni) {
    $this->conn;

    // Verificar si la persona existe antes de consultar sus datos
    if (!$this->existePersonaByDNI($dni)) {
        return "La persona con DNI $dni no existe.";
    }

    // Consulta para obtener información de una persona por su DNI
    $sql = "SELECT * FROM persona WHERE Dni=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $dni);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // La persona existe, obtener y devolver la información
        $personaInfo = $result->fetch_assoc();
        return $personaInfo; // Aquí podrías hacer lo que desees con esta información
    } else {
        return "La persona con DNI $dni no existe.";
    }
}

    // Método para actualizar información de una persona por su DNI
    public function actualizarPersona(Persona $persona) {
    $this->conn;

    // Preparar la consulta SQL para actualizar una persona por su DNI
    $sql = "UPDATE tblpersona SET primerNombre=?, segundoNombre=?, primerApellido=?, segundoApellido=?, dni=?, telefono=?, sexo=?, fechaDeNacimiento=?, Edad=?, direccion=?, correoElectronico=? WHERE dni=?";
    $stmt = $this->conn->prepare($sql);

    // Verificar si la preparación de la consulta fue exitosa
    if ($stmt) {
        // Obtener los datos de la persona para actualizar
        $dni = $persona->getDni();
        $idPersona = $persona->getDni();
        $primerNombre = $persona->getPrimerNombre();
        $segundoNombre = $persona->getSegundoNombre();
        $primerApellido = $persona->getPrimerApellido();
        $segundoApellido = $persona->getSegundoApellido();
        $telefono = $persona->getTelefono();
        $sexo = $persona->getSexo();
        $fechaDeNacimiento = $persona->getFechaDeNacimiento();
        $Edad = $persona->getEdad();
        $direccion = $persona->getDireccion();
        $correoElectronico = $persona->getCorreoElectronico();

        // Enlazar parámetros
        $stmt->bind_param("issssssssiss", 
            $idPersona,
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $dni,
            $telefono,
            $sexo,
            $fechaDeNacimiento,
            $Edad,
            $direccion,
            $correoElectronico,
            $dni // Usamos el DNI como referencia para la actualización
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return "Persona actualizada correctamente.";
        } else {
            return "Hubo un problema al actualizar la persona.";
        }
    } else {
        return "Hubo un error en la preparación de la consulta.";
    }
}


    // Método para eliminar una persona por su DNI
    public function eliminarPersona($dni) {
        $this->conn;

        // Preparar la consulta SQL para eliminar una persona por su DNI
        $sql = "DELETE FROM tblpersona WHERE dni=?";
        $stmt = $this->conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Enlazar parámetros
            $stmt->bind_param("s", $dni);

            // Ejecutar la consulta
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
