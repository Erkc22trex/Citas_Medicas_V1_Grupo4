<?php
include 'Persona.php';
include 'informacion.php';
class DAOpersona {
    private $con;
    public function __construct() {
    }
    public function conectar() {
        $this->con = new mysqli(SERVIDOR, USUARIO, CLAVES, BD) or die ("Error al conectar");
    }
        //desconectar de la base de datos
    public function desconectar() {
        $this->con->close;}
        
    public function insertarPersona($objeto){
    $p = new Persona();
    $p->$objeto;
    // Crear la sentencia SQL
    $sql = "INSERT INTO tblpersona VALUES (
            '".$p->getIdPersona()."', 
            '".$p->getPrimerNombre()."', 
            '".$p->getSegundoNombre()."', 
            '".$p->getPrimerApellido()."', 
            '".$p->getSegundoApellido()."', 
            '".$p->getDni()."', 
            '".$p->getTelefono()."', 
            '".$p->getSexo()."', 
            '".$p->getFechaDeNacimiento()."', 
            '".$p->getEdad()."', 
            '".$p->getDireccion()."', 
            '".$p->getCorreoElectronico()."'
        )";
    if($this->con->query($sql)){
    //mensaje de éxito con sweet alert                             
    echo"'Inserción exitosa',text:'Se ha agreado con éxito a la base de datos.'";
    }else{  
    //mensaje de error con sweet alert   
    echo"'No se ha podido agregar a la base de datos.'";
    }
    $this->desconectar();  
}    

    }
    $obj = new DAOpersona();
$np = new Persona();
$np->setIdPersona(1);
$np->setPrimerNombre("Erick");
$np->setSegundoNombre("David");
$np->setPrimerApellido("Trejo");
$np->setSegundoApellido("Cruz");
$np->setDni("1"); // Asegurarse de que el DNI sea una cadena
$np->setTelefono(88426812);
$np->setSexo("Hombre");
$np->setFechaDeNacimiento("30082001"); // Asegurarse de que la fecha sea una cadena
$np->setEdad(22);
$np->setDireccion("Tegucigalpa");
$np->setCorreoElectronico("et25828@gmail.com");

$obj->insertarPersona($np);