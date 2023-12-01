<?php

class Itinerario {

    private $idItinerario;
    private $idMedico;
    private $horaEntrada;
    private $horaSalida;

    public function __construct()
    {
        
    }

    // Getters
    public function getIdItinerario()
    {
        return $this->idItinerario;
    }

    public function getIdMedico()
    {
        return $this->idMedico;
    }

    public function getHoraEntrada()
    {
        return $this->horaEntrada;
    }

    public function getHoraSalida()
    {
        return $this->horaSalida;
    }

    // Setters
    public function setIdItinerario($idItinerario)
    {
        $this->idItinerario = $idItinerario;
    }

    public function setIdMedico($idMedico)
    {
        $this->idMedico = $idMedico;
    }

    public function setHoraEntrada($horaEntrada)
    {
        $this->horaEntrada = $horaEntrada;
    }

    public function setHoraSalida($horaSalida)
    {
        $this->horaSalida = $horaSalida;
    }
}