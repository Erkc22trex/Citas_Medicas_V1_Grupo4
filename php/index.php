
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include 'DAOPersona.php';
        $daoPersona = new DAOPersona();

    // Crear un objeto Persona con los datos a insertar
    $persona = new Persona();
    $persona->setPrimerNombre("Daniela");
    $persona->setSegundoNombre("Alexandra");
    $persona->setPrimerApellido("Romero");
    $persona->setSegundoApellido("Giron");
    $persona->setDni("0803-2001-00564");
    $persona->setTelefono("8947-6514");
    $persona->setSexo("Hombre");
    $persona->setFechaDeNacimiento("2001-11-08");
    $persona->setEdad("22");
    $persona->setDireccion("Tegucigalpa");
    $persona->setCorreoElectronico("alexa.gion@unah.hn");

    // Insertar la persona en la base de datos
    $resultado = $daoPersona->ingresarPersona($persona);

    // Verificar el resultado de la inserción
    echo $resultado;
        ?>
    </body>
</html>
