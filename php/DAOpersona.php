<?php
include 'Persona.php';
include 'informacion.php';
class DAOpersona {
    private $con;
    public function __construct() {
        
 //conectar a la base de datos
    }
    public function conectar() {
        $this->con = new mysqli(SERVIDOR, USUARIO, CLAVES, BD) or die ("Error al conectar");
    }
    //desconectar de la base de datos
    public function desconectar() {
        this->con->close;}
}             
