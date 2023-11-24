<?php

class Paciente extends Persona {
    //atributos
    private $idPaciente;

    // public function __construct($idPersona, $nombre, $apellido, $telefono, $dni, $edad, $fechaNacimiento, $direccion, $idPaciente) {
    //     parent::__construct($idPersona, $nombre, $apellido, $telefono, $dni, $edad, $fechaNacimiento, $direccion);
    //     $this->idPaciente = $idPaciente;
    // }
    
    //constructor
    public function __construct() {
        
    }
    
    // Getters y setters 
    public function getIdPaciente() {
        return $this->idPaciente;
    }

    public function setIdPaciente($idPaciente){
        $this->idPaciente = $idPaciente;
    }
}

