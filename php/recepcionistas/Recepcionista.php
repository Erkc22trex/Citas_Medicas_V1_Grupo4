<?php

include "../personas/Persona.php";

class Recepcionista extends Persona {
    //atributos
    private $idRecepcionista;

    //constructor
    public function __construct() {
        
    }
    
    // Getters 
    public function getIdRecepcionista() {
        return $this->idRecepcionista;
    }

    // Setters
    public function setIdRecepcionista($idRecepcionista){
        $this->idRecepcionista = $idRecepcionista;
    }
}
