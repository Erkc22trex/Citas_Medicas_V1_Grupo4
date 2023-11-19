<?php
include 'DAOPersona.php';

// Verificar si se recibió una solicitud POST desde el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Instanciar y utilizar DAOPersona para manejar la acción solicitada
    $daoPersona = new DAOPersona();

    // Verificar la acción solicitada
    if ($_POST["accion"] === "Ver Persona") {
        // Código para ver persona según requerimientos
        $dni = $_POST["dni"];
        $resultado = $daoPersona->verPersona($dni);

        if (is_array($resultado)) {
            // Mostrar los datos en una tabla o como desees
            echo "<table>";
            foreach ($resultado as $campo => $valor) {
                echo "<tr><td>$campo</td><td>$valor</td></tr>";
            }
            echo "</table>";
        } else {
            echo $resultado; // Mostrar mensaje de error si la persona no se encuentra
        }
    } elseif ($_POST["accion"] === "Actualizar Persona") {
        // Código para actualizar persona según requerimientos
    } elseif ($_POST["accion"] === "Eliminar Persona") {
        // Código para eliminar persona según requerimientos
    } elseif ($_POST["accion"] === "Insertar Persona") {
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

        // Llamar a la función para ingresar persona en DAOPersona
        $resultado = $daoPersona->ingresarPersona($persona);
        echo $resultado;
    }
}

// Verificar si se recibió una solicitud GET desde el formulario de búsqueda por DNI
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Obtener el DNI ingresado para la búsqueda
    $dni = $_GET["dni"];

    // Instanciar y utilizar DAOPersona para buscar la persona por DNI
    $daoPersona = new DAOPersona();
    $resultadoBusqueda = $daoPersona->verPersona($dni);

    // Mostrar el resultado de la búsqueda en la tabla de resultados del formulario
    // ...
}



