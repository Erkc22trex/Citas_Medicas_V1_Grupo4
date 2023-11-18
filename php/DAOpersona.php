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

    public function ingresarPersona($objeto) {
    $p = $objeto;

    // Consulta de inserción con placeholders (?)
     $sql = "INSERT INTO persona (Primer_Nombre, Segundo_Nombre, Primer_Apellido, Segundo_Apellido, Dni, Telefono, Sexo, Fecha_de_nacimiento, Edad, Direccion, Correo_Electronico) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);

    if ($stmt) {
        // Enlazar parámetros
        $stmt->bind_param("ssssisssiss",
            $p->getPrimerNombre(),
            $p->getSegundoNombre(),
            $p->getPrimerApellido(),
            $p->getSegundoApellido(),
            $p->getDni(),
            $p->getTelefono(),
            $p->getSexo(),
            $p->getFechaDeNacimiento(),
            $p->getEdad(),
            $p->getDireccion(),
            $p->getCorreoElectronico()
        );

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito
            return "Se ha agregado con éxito a la base de datos.";
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

        // Consulta para obtener información de una persona por su DNI
        $sql = "SELECT * FROM tblpersona WHERE dni=?";
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
