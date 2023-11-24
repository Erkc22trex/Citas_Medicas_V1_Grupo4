<?php

class Persona  {
    //atributos
    private $idPersona;
    private $nombre;
    private $apellido;
    private $telefono;
    private $dni;
    private $edad;
    private $sexo;
    private $fechaNacimiento;
    private $direccion;
    private $correo;
    
    // constructor
    public function __construct() {
        // $this-> $idPersona = 0;
        // $this-> $nombre = "";
        // $this-> $apellido = "";
        // $this-> $telefono = "";
        // $this-> $dni = "";
        // $this-> $edad = 0;
        // $this-> $sexo = "";
        // $this-> $fechaNacimiento = "";
        // $this-> $direccion = "";
        // $this-> $correo = "";
    }

//    public function __construct($idPersona, $nombre, $apellido, $telefono, $dni, $edad, $sexo, $fechaNacimiento, $direccion, $correo) {
//         $this-> $idPersona = $idPersona;
//         $this-> $nombre = $nombre;
//         $this-> $apellido = $apellido;
//         $this-> $telefono = $telefono;
//         $this-> $dni = $dni;
//         $this-> $edad = $edad;
//         $this-> $sexo = $sexo;
//         $this-> $fechaNacimiento = $fechaNacimiento;
//         $this-> $direccion = $direccion;
//         $this-> $correo = $correo;
//    }

    // Getters 
    public function getIdPersona() {
        return $this->idPersona;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }
    
    public function getTelefono() {
        return $this->telefono;
    }

    public function getDni() {
        return $this->dni;
    }
    
    public function getEdad() {
        return $this->edad;
    }
    public function getSexo() {
        return $this->sexo;
    }

    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getCorreo() {
        return $this->correo;
    }

    // Setters
    public function setIdPersona($idPersona){
        $this->idPersona = $idPersona;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function setDni($dni){
        $this->dni = $dni;
    }
    
    public function setEdad($edad){
        $this->edad = $edad;
    }

    public function setSexo($sexo){
        $this->sexo = $sexo;
    }

    public function setFechaNacimiento($fechaNacimiento){
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
    }

    public function setCorreo($correo){
        $this->correo = $correo;
    }

}
