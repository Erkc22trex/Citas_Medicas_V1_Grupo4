<?php


class Paciente {
    //atributos
    private $id;
    private $dni;
    private $nombre;
    private $telefono;
    private $citas;
    private $sexo;
    private $fch_nac;
    private $correo;
    
    //constructor
    public function __construct() {
        
    }
    // Getters y setters 
    public function getIdPaciente() {
        return $this->id;
    }
    
    public function getDni() {
        return $this->dni;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTelefono() {
        return $this->telefono;
    }
    
        public function getCitas() {
        return $this->citas;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getFchNac() {
        return $this->fch_nac;
    }

    public function getCorreo() {
        return $this->correo;
    }

    public function setIdPersona($id){
        $this->id = $id;
    }
    
    public function setDni($dni){
        $this->dni = $dni;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }
    
        public function setCitas($citas){
        $this->citas = $citas;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }

    public function setFchNac($fchNac){
        $this->fch_nac = $fchNac;
    }

    public function setCorreo($correo){
        $this->correo = $correo;
    }

}