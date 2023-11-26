<?php

include "../personas/Persona.php";

class Medico extends Persona
{
    // ATRIBUTOS
    private $idMedico;
    private $especialidad;

    // CONSTRUCTOR
    public function __construct()
    {
    }
    
    // GETTER
    public function getIdMedico()
    {
        return $this->idMedico;
    }

    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    // SETTER
    public function setEspecialidad($especialidad): void
    {
        $this->especialidad = $especialidad;
    }

    public function setIdMedico($idMedico)
    {
        $this->idMedico = $idMedico;
    }
}
