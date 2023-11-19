<?php


class Persona {
    //atributos
    private $conn;
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

}
