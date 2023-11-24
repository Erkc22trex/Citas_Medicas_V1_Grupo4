<<<<<<< HEAD
<?php
include 'DAOPersona.php';

// Verificar si se recibió una solicitud POST desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se está recibiendo la acción 'Insertar Persona'
         if (isset($_POST['accion'])){
        echo "alert(' Wnrew XCss' );";
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

        // Instancia la clase DAOPersona
        $daoPersona = new DAOPersona();

        // Llama al método ingresarPersona con el objeto Persona
        $resultado = $daoPersona->ingresarPersona($p);

        // Verifica si la inserción fue exitosa o si hubo algún error
        if (strpos($resultado, 'correctamente') !== false) {
            // Inserción exitosa
            error_log("Inserción exitosa: " . $resultado);
        } else {
            // Error en la inserción
            error_log("Error al insertar persona: " . $resultado);
        }

        echo $resultado; // Esto puede ayudar a ver el resultado en la respuesta del AJAX
    }
 else {
        echo 'alert(" no lo hice" )';    
    }
}
=======
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
>>>>>>> f668cbdd482faa1ef22eef8edd28bcf87fdef1fa
