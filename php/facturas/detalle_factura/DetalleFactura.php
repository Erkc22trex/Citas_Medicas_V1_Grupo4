<?php

class DetalleFactura {

    private $idDetalleFactura;
    private $idFactura;
    private $descripcion;
    private $precio;

    public function __construct() {
        
    }

    // Getters
    public function getIdDetalleFactura() {
        return $this->idDetalleFactura;
    }

    public function getIdFactura() {
        return $this->idFactura;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getPrecio() {
        return $this->precio;
    }

    // Setters
    public function setIdDetalleFactura($idDetalleFactura) {
        $this->idDetalleFactura = $idDetalleFactura;
    }

    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setPrecio($precio) {
        $this->precio = $precio;
    }
    
}