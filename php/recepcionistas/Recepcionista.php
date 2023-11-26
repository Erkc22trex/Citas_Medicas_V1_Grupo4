<?php

include "../personas/Persona.php";

class Recepcionista extends Persona {
    //atributos
    private $idRecepcionista;

    //constructor
    public function __construct() {
        
    }
    
    // Getters y setters 
    public function getIdRecepcionista() {
        return $this->idRecepcionista;
    }

    public function setIdRecepcionista($idRecepcionista){
        $this->idRecepcionista = $idRecepcionista;
    }
}
