<?php
include 'Persona.php';
include 'informacion.php';

class DAOPersona {
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

    public function desconectar() {
        $this->conn->close();
    }

    public function getTabla() {
        $sql = "SELECT * FROM persona";
        $this->conectar();
        $res = $this->conn->query($sql);

        $tabla = "<table class='table table-dark'>
                    <!-- Encabezados de la tabla -->
                    <!-- ... -->
                    <tbody>";

        while ($tupla = mysqli_fetch_assoc($res)) {
            // Construcción de filas con datos de la base de datos
            // ...
        }

        $tabla .= "</tbody></table>";
        $res->close();
        $this->desconectar();
        return $tabla;
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

    public function verPersona($dni) {
    $sql = "SELECT * FROM persona WHERE Dni=?";
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

public function actualizarPersona(Persona $persona) {
    $sql = "UPDATE persona SET Primer_Nombre=?, Segundo_Nombre=?, Primer_Apellido=?, Segundo_Apellido=?, Telefono=?, Sexo=?, Fecha_de_nacimiento=?, Edad=?, Direccion=?, Correo_Electronico=? WHERE Dni=?";
    $stmt = $this->conn->prepare($sql);

    if ($stmt) {
        $primerNombre = $persona->getPrimerNombre();
        $segundoNombre = $persona->getSegundoNombre();
        $primerApellido = $persona->getPrimerApellido();
        $segundoApellido = $persona->getSegundoApellido();
        $telefono = $persona->getTelefono();
        $sexo = $persona->getSexo();
        $fechaDeNacimiento = $persona->getFechaDeNacimiento();
        $edad = $persona->getEdad();
        $direccion = $persona->getDireccion();
        $correoElectronico = $persona->getCorreoElectronico();
        $dni = $persona->getDni();

        $stmt->bind_param("ssssisssiss",
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $segundoApellido,
            $telefono,
            $sexo,
            $fechaDeNacimiento,
            $edad,
            $direccion,
            $correoElectronico,
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

public function eliminarPersona($dni) {
    $sql = "DELETE FROM persona WHERE Dni=?";
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