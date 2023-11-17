<?php
class Medico {
//ATRIBUTOS
    private $idMedico;
    private $consultorio;
    private $horario;
    
    private $fecha;
    private $hora;
    private $paciente;
    private $motivo;
    private $diagnostico;
    private $tratamiento;
//CONSTRUCTOR
    public function __construct() {
       
    }
//GETTER Y SETTER
    public function getIdMedico() {
        return $this->idMedico;
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

    public function getHora() {
        return $this->hora;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function getDiagnostico() {
        return $this->diagnostico;
    }

    public function getTratamiento() {
        return $this->tratamiento;
    }
    public function setIdMedico($idMedico): void {
        $this->idMedico = $idMedico;
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

    public function setHora($hora): void {
        $this->hora = $hora;
    }

    public function setPaciente($paciente): void {
        $this->paciente = $paciente;
    }

    public function setMotivo($motivo): void {
        $this->motivo = $motivo;
    }

    public function setDiagnostico($diagnostico): void {
        $this->diagnostico = $diagnostico;
    }

    public function setTratamiento($tratamiento): void {
        $this->tratamiento = $tratamiento;
    }
//METODOS PROPIOS
        public function intinerario(){
    $medico = new Medico();
$medico->setIdMedico(1);
$medico->setConsultorio("101");
$medico->setHorario("Lunes a Viernes de 8:00 a 17:00");
$medico->setFecha("2023-11-20");
$medico->setHora("10:00");
$medico->setPaciente("Juan Pérez");
$medico->setMotivo("Dolor de cabeza");
$medico->setDiagnostico("Infección sinusal");
$medico->setTratamiento("Antibióticos");
return $medico; // Devolver la instancia configurada
    }
}
$medico = new Medico(); // Crear una instancia de Medico
$medico = $medico->intinerario();
echo $medico->getFecha(); // 2023-11-20
echo $medico->getHora(); // 10:00
echo $medico->getPaciente(); // Juan Pérez
echo $medico->getMotivo(); // Dolor de cabeza
echo $medico->getDiagnostico(); // Infección sinusal
echo $medico->getTratamiento(); // Antibióticos

