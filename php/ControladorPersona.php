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
