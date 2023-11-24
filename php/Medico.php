<?php
class Medico extends Persona {
//ATRIBUTOS
    private $especialidad;
    private $consultorio;
    private $horario;
    
    private $fecha;
    private $horaEntrada;
    private $horaSalida;
    private $estado;

//CONSTRUCTOR
    public function __construct() {
       
    }
//GETTER Y SETTER
    public function getEspecialidad() {
        return $this->especialidad;
    }

    public function getConsultorio() {
        return $this->consultorio;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHoraEntrada() {
        return $this->horaEntrada;
    }

    public function getHoraSalida() {
        return $this->horaSalida;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEspecialidad($especialidad): void {
        $this->especialidad = $especialidad;
    }

    public function setConsultorio($consultorio): void {
        $this->consultorio = $consultorio;
    }

    public function setHorario($horario): void {
        $this->horario = $horario;
    }

    public function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    public function setHoraEntrada($horaEntrada): void {
        $this->horaEntrada = $horaEntrada;
    }

    public function setHoraSalida($horaSalida): void {
        $this->horaSalida = $horaSalida;
    }

    public function setEstado($estado): void {
        $this->estado = $estado;
    }


//METODOS PROPIOS
        

}