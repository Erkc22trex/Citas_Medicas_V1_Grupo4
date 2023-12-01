<?php

class Expediente {

    private $idExpediente;
    private $idPaciente;
    private $idMedico;
    private $dianostico;
    private $tratamiento;
    private $observaciones;

    function __construct()
    {
        
    }

    // Getters
    function getIdExpediente() {
        return $this->idExpediente;
    }

    function getIdPaciente() {
        return $this->idPaciente;
    }

    function getIdMedico() {
        return $this->idMedico;
    }

    function getDianostico() {
        return $this->dianostico;
    }

    function getTratamiento() {
        return $this->tratamiento;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    // Setters
    function setIdExpediente($idExpediente) {
        $this->idExpediente = $idExpediente;
    }

    function setIdPaciente($idPaciente) {
        $this->idPaciente = $idPaciente;
    }

    function setIdMedico($idMedico) {
        $this->idMedico = $idMedico;
    }

    function setDianostico($dianostico) {
        $this->dianostico = $dianostico;
    }

    function setTratamiento($tratamiento) {
        $this->tratamiento = $tratamiento;
    }

    function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

}