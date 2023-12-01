<?php

class Factura {

    private $idFactura;
    private $idCita;
    private $montoTotal;
    private $fechaEmision;
    private $estado;
    private $tipoPago;

    public function __construct() {
        
    }

    // Getters
    public function getIdFactura() {
        return $this->idFactura;
    }

    public function getIdCita() {
        return $this->idCita;
    }

    public function getMontoTotal() {
        return $this->montoTotal;
    }

    public function getFechaEmision() {
        return $this->fechaEmision;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getTipoPago() {
        return $this->tipoPago;
    }

    // Setters
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    public function setIdCita($idCita) {
        $this->idCita = $idCita;
    }

    public function setMontoTotal($montoTotal) {
        $this->montoTotal = $montoTotal;
    }

    public function setFechaEmision($fechaEmision) {
        $this->fechaEmision = $fechaEmision;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setTipoPago($tipoPago) {
        $this->tipoPago = $tipoPago;
    }

}