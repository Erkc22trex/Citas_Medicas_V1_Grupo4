<?php

class Cita {
    //atributos
    private $idCita;
    private $idPaciente;
    private $idMedico;
    private $fecha;
    private $hora;
    private $estado;

    public function __construct() {}

    // Getters
    public function getIdCita() {
        return $this->idCita;
    }

    public function getIdPaciente() {
        return $this->idPaciente;
    }

    public function getIdMedico() {
        return $this->idMedico;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getEstado() {
        return $this->estado;
    }

    // Setters
    public function setIdCita($idCita){
        $this->idCita = $idCita;
    }

    public function setIdPaciente($idPaciente){
        $this->idPaciente = $idPaciente;
    }

    public function setIdMedico($idMedico){
        $this->idMedico = $idMedico;
    }

    public function setFecha($fecha){
        $this->fecha = $fecha;
    }

    public function setHora($hora){
        $this->hora = $hora;
    }

    public function setEstado($estado){
        $this->estado = $estado;
    }

}