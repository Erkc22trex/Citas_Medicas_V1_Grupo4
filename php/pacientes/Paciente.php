<?php

class Paciente extends Persona {
    //atributos
    // private $conn;
    // private $dni;
    // private $nombre;
    // private $telefono;
    // private $citas;
    // private $sexo;
    // private $fch_nac;
    // private $correo;
    private $id_paciente;

    public function __construct($id, $nombre, $apellido, $fechaNacimiento, $otrosDatos, $rol, $id_paciente) {
        parent::__construct($id, $nombre, $apellido, $fechaNacimiento, $otrosDatos, $rol);
        $this->id_paciente = $id_paciente;
    }
    
    //constructor
    public function construct() {
        
    }
    
    // Getters y setters 
    public function getIdPaciente() {
        return $this->id;
    }

    public function setIdPaciente($id){
        $this->id = $id;
    }

}

