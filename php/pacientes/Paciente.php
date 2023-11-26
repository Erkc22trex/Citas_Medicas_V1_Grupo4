<?php

include "../personas/Persona.php";

class Paciente extends Persona {
    //atributos
    private $idPaciente;

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

