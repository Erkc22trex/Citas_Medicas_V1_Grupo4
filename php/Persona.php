<?php


class Persona {
    //atributos
    private $idPersona;
    private $primerNombre;
    private $segundoNombre;
    private $primerApellido;
    private $SegundoApellido;
    private $dni;
    private $telefono;
    private $sexo;
    private $fechaDeNacimiento;
    private $Edad;
    private $direccion;
    private $correoElectronico;
    
//    constructor
    public function __construct() {
        
    }
    // Getters y setters 
    public function getIdPersona() {
        return $this->idPersona;
    }

    public function getPrimerNombre() {
        return $this->primerNombre;
    }

    public function getSegundoNombre() {
        return $this->segundoNombre;
    }

    public function getPrimerApellido() {
        return $this->primerApellido;
    }

    public function getSegundoApellido() {
        return $this->SegundoApellido;
    }

    public function getDni() {
        return $this->dni;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getFechaDeNacimiento() {
        return $this->fechaDeNacimiento;
    }

    public function getEdad() {
        return $this->Edad;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getCorreoElectronico() {
        return $this->correoElectronico;
    }

    public function setIdPersona($idPersona){
        $this->idPersona = $idPersona;
    }

    public function setPrimerNombre($primerNombre){
        $this->primerNombre = $primerNombre;
    }

    public function setSegundoNombre($segundoNombre){
        $this->segundoNombre = $segundoNombre;
    }

    public function setPrimerApellido($primerApellido){
        $this->primerApellido = $primerApellido;
    }

    public function setSegundoApellido($SegundoApellido){
        $this->SegundoApellido = $SegundoApellido;
    }

    public function setDni($dni){
        $this->dni = $dni;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }

    public function setFechaDeNacimiento($fechaDeNacimiento){
        $this->fechaDeNacimiento = $fechaDeNacimiento;
    }

    public function setEdad($Edad){
        $this->Edad = $Edad;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    public function setCorreoElectronico($correoElectronico){
        $this->correoElectronico = $correoElectronico;
    }
    public function ingresarPersona() {  
        global $conn;

        // Preparar la consulta SQL para agregar una persona
        $sql = "INSERT INTO tabla_personas (primerNombre, segundoNombre, primerApellido, segundoApellido, dni, telefono, sexo, fechaDeNacimiento, Edad, direccion, correoElectronico) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Enlazar parámetros
            $stmt->bind_param("sssssssssss", $this->primerNombre, $this->segundoNombre, $this->primerApellido, $this->SegundoApellido, $this->dni, $this->telefono, $this->sexo, $this->fechaDeNacimiento, $this->Edad, $this->direccion, $this->correoElectronico);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return "Persona agregada correctamente.";
            } else {
                return "Hubo un problema al agregar la persona.";
            }
        } else {
            return "Hubo un error en la preparación de la consulta.";
        }
    }
    }
    // Método para ver información de una persona por su DNI
    public function verPersona($dni) {
        global $conn;

        // Consulta para obtener información de una persona por su DNI
        $sql = "SELECT * FROM tabla_personas WHERE dni=?";
        $stmt = $conn->prepare($sql);
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
    public function actualizarPersona($dni) {
        global $conn;

        // Preparar la consulta SQL para actualizar una persona por su DNI
        $sql = "UPDATE tabla_personas SET primerNombre=?, segundoNombre=?, primerApellido=?, segundoApellido=?, dni=?, telefono=?, sexo=?, fechaDeNacimiento=?, Edad=?, direccion=?, correoElectronico=? WHERE dni=?";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Enlazar parámetros
            $stmt->bind_param("ssssssssssss", $this->primerNombre, $this->segundoNombre, $this->primerApellido, $this->SegundoApellido, $this->dni, $this->telefono, $this->sexo, $this->fechaDeNacimiento, $this->Edad, $this->direccion, $this->correoElectronico, $dni);

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
        global $conn;

        // Preparar la consulta SQL para eliminar una persona por su DNI
        $sql = "DELETE FROM tabla_personas WHERE dni=?";
        $stmt = $conn->prepare($sql);

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


