<?php
include 'DAOPersona.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear un objeto Persona con los datos del formulario
    $persona = new Persona();
    $persona->setPrimerNombre($_POST["primerNombre"]);
    $persona->setSegundoNombre($_POST["segundoNombre"]);
    $persona->setPrimerApellido($_POST["primerApellido"]);
    $persona->setSegundoApellido($_POST["segundoApellido"]);
    $persona->setDni($_POST["dni"]);
    $persona->setTelefono($_POST["telefono"]);
    $persona->setSexo($_POST["sexo"]);
    $persona->setFechaDeNacimiento($_POST["fechaDeNacimiento"]);
    $persona->setEdad($_POST["edad"]);
    $persona->setDireccion($_POST["direccion"]);
    $persona->setCorreoElectronico($_POST["correoElectronico"]);

    // Instanciar y utilizar DAOPersona para ingresar la persona
    $daoPersona = new DAOPersona();
    $resultado = $daoPersona->ingresarPersona($persona);

    // Verificar el resultado de la inserción
    echo $resultado;
}
?>
