<?php
include 'DAOPersona.php';
$daoPersona = new DAOPersona();

// Verificar si se recibió una solicitud POST desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se está recibiendo la acción 'Insertar Persona'
         if (isset($_POST['accion'])){
        // Crear objeto Persona con los datos del formulario
        $p = new Persona();
        $p->setPrimerNombre($_POST['primerNombre']);
        $p->setSegundoNombre($_POST['segundoNombre']);
        $p->setPrimerApellido($_POST['primerApellido']);
        $p->setSegundoApellido($_POST['segundoApellido']);
        $p->setDni($_POST['dni']);
        $p->setTelefono($_POST['telefono']);
        $p->setSexo($_POST['sexo']);
        $p->setFechaDeNacimiento($_POST['fechaDeNacimiento']);
        $p->setEdad($_POST['edad']);
        $p->setDireccion($_POST['direccion']);
        $p->setCorreoElectronico($_POST['correoElectronico']);
        // Llama al método ingresarPersona con el objeto Persona
        $resultado = $daoPersona->ingresarPersona($p);

        //BUSCAR PERSONA
}       if ($dni = $_POST['dni']){ // Obtener el DNI de la solicitud
        $personaEncontrada = $daoPersona->verPersona($dni);
        echo json_encode($personaEncontrada);
        exit(); 
        
        //ACTUALIZAR PERSONA
}       if (isset($_POST['accion3'])){
        echo 'He llegado aqui';
        $dni = $_POST['dni'];
        $personaEncontrada = $daoPersona->verPersona($dni);
        $p->setPrimerNombre($_POST['primerNombre']);
        $p->setSegundoNombre($_POST['segundoNombre']);
        $p->setPrimerApellido($_POST['primerApellido']);
        $p->setSegundoApellido($_POST['segundoApellido']);
        $p->setDni($_POST['dni']);
        $p->setTelefono($_POST['telefono']);
        $p->setSexo($_POST['sexo']);
        $p->setFechaDeNacimiento($_POST['fechaDeNacimiento']);
        $p->setEdad($_POST['edad']);
        $p->setDireccion($_POST['direccion']);
        $p->setCorreoElectronico($_POST['correoElectronico']);
        $resultado = $daoPersona->actualizarPersona($persona);
        exit();
        }
        
        //ELIMINAR PERSONA
    }
