<?php

include "../personas/Persona.php";

class Usuario extends Persona {
    //atributos
    private $idUsuario;
    private $rol;
    private $password;
    private $estado;

    //constructor
    public function __construct() {}
    
    // Getters 
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getRol() {
        return $this->rol;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEstado() {
        return $this->estado;
    }

    // setters
    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }

    public function setRol($rol){
        $this->rol = $rol;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }
}
