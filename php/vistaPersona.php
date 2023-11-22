<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
    <meta charset="UTF-8">
    <title>Administrar Personas</title>
</head>
<body>
    <h2 style="text-align: center;">Ingresar Persona</h2>
     <form id="formularioPersona" action="./ControladorPersona.php" method="POST" style="width: 80%; margin: 20px auto; display: flex; flex-wrap: wrap; justify-content: space-between;">
    <div style="width: 48%;">
            <div class="mb-3">
        <label for="primerNombre" class="form-label">Primer Nombre:</label>
        <input type="text" class="form-control" id="primerNombre" name="primerNombre" required><br><br>
    </div>
         </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="segundoNombre" class="form-label">Segundo Nombre:</label>
        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre"><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="primerApellido" class="form-label">Primer Apellido:</label>
        <input type="text" class="form-control" id="primerApellido" name="primerApellido" required><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="segundoApellido" class="form-label">Segundo Apellido:</label>
        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido"><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="dni" class="form-label">DNI:</label>
        <input type="text" class="form-control" id="dni" name="dni" required><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" class="form-control" id="telefono" name="telefono" required><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="sexo" class="form-label">Sexo:</label>
        <input type="text" class="form-control" id="sexo" name="sexo" required><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="fechaDeNacimiento" class="form-label">Fecha de Nacimiento:</label>
        <input type="date" class="form-control" id="fechaDeNacimiento" name="fechaDeNacimiento" placeholder="AAAA-MM-DD"><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="edad" class="form-label">Edad:</label>
        <input type="number" class="form-control" id="edad" name="edad" required><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" class="form-control" id="direccion" name="direccion" required><br><br>
    </div>
    </div>

    <div style="width: 48%;">
            <div class="mb-3">
        <label for="correoElectronico" class="form-label">Correo Electrónico:</label>
        <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required><br><br>
    </div>
    </div>

    <div class="botones">
        <input type="submit" class="btn btn-primary" name="accion"  id ="accion" value="Insertar Persona">
       <input type="submit" class="btn btn-primary" name="accion2" id="accion2" value="Ver Persona">
        <input type="submit" class="btn btn-primary" name="accion3" id="accion3" value="Actualizar Persona">
        <input type="submit" class="btn btn-primary" name="accion4" value="Eliminar Persona">-->
    </div> 
</form>
    <script>
        $(document).ready(function() {
    $('#accion').click(function(e) {
        e.preventDefault(); // Evitar el comportamiento por defecto del botón (enviar formulario)

        // Obtener los valores de los campos del formulario
        var primerNombre = $('#primerNombre').val();
        var segundoNombre = $('#segundoNombre').val();
        var primerApellido = $('#primerApellido').val();
        var segundoApellido = $('#segundoApellido').val();
        var dni = $('#dni').val();
        var telefono = $('#telefono').val();
        var sexo = $('#sexo').val();
        var fechaDeNacimiento = $('#fechaDeNacimiento').val();
        var edad = $('#edad').val();
        var direccion = $('#direccion').val();
        var correoElectronico = $('#correoElectronico').val();
        // Obtener el resto de los campos...

        // Realizar solicitud AJAX al controlador PHP
        $.ajax({
            type: 'POST',
            url: 'ControladorPersona.php',
            data: {
                accion: 'insertarPersona', // Indicador de acción para insertar persona
                primerNombre: primerNombre,
                segundoNombre: segundoNombre,
                primerApellido: primerApellido,
                segundoApellido: segundoApellido,
                dni: dni,
                telefono: telefono,
                sexo: sexo,
                fechaDeNacimiento: fechaDeNacimiento,
                edad: edad,
                direccion: direccion,
                correoElectronico: correoElectronico,
                
                
                // Resto de los campos...
            },
            success: function(response) {
                // Mostrar un mensaje de éxito o manejar la respuesta
                alert(response); // Puedes mostrar una alerta, por ejemplo
            },
            error: function(xhr, status, error) {
                // Manejar errores si la solicitud falla
                console.error(error);
                alert("Hubo un error al ingresar la persona.");
            }
        });
    });
});
</script>
  
<!-- formulario para búsquedas -->
              <form action="ControladorPersona.php" method="post" name="formulario2" id="formulario2" style="width: 200px; position: absolute; top: 10px; right: 10px;">
    <div class="mb-1">
        <label for="buscar">Buscar por DNI:</label>
        <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Ingrese DNI" >
    </div>
</form>
<script>
    $(document).ready(function() {
    $('#accion2').click(function(e) {
        e.preventDefault(); // Evitar el comportamiento por defecto del botón (enviar formulario)

        var dni = $('#buscar').val(); // Obtener el DNI ingresado

        // Realizar solicitud AJAX al controlador PHP
        $.ajax({
            type: 'POST',
            url: 'ControladorPersona.php', // Ruta del controlador
            data: { action: 'verPersona', dni: dni }, // Datos a enviar al servidor
            success: function(response) {
                // Verificar si la respuesta contiene datos de la persona
                if (response !== "La persona con DNI " + dni + " no existe.") {
                    // Llenar los campos del formularioPersona con los datos recibidos
                    var persona = JSON.parse(response);

                    $('#primerNombre').val(persona.Primer_Nombre);
                    $('#segundoNombre').val(persona.Segundo_Nombre);
                    $('#primerApellido').val(persona.Primer_Apellido);
                    $('#segundoApellido').val(persona.Segundo_Apellido);
                    $('#dni').val(persona.Dni);
                    $('#telefono').val(persona.Telefono);
                    $('#sexo').val(persona.Sexo);
                    $('#fechaDeNacimiento').val(persona.Fecha_De_Nacimiento);
                    $('#edad').val(persona.Edad);
                    $('#direccion').val(persona.Direccion);
                    $('#correoElectronico').val(persona.Correo_Electronico);
                    // Resto de los campos...

                    alert("Datos de la persona obtenidos correctamente.");
                } else {
                    alert(response); // Mostrar mensaje si la persona no existe
                }
            },
            error: function(xhr, status, error) {
                // Manejar errores si la solicitud falla
                console.error(error);
                alert("Hubo un error al buscar la persona.");
            }
        });
    });
});
    </script>
    
    <!-- Actualizar Persona -->
    <script>
        $(document).ready(function() {
    $('#accion3').click(function(e) {
        e.preventDefault(); // Evitar el comportamiento por defecto del botón (enviar formulario)

        // Obtener el DNI de la persona que se desea actualizar
//        var dni = $('#dni').val();
        // Obtener los valores actualizados de los campos del formulario
        var primerNombre = $('#primerNombre').val();
        var segundoNombre = $('#segundoNombre').val();
        var primerApellido = $('#primerApellido').val();
        var segundoApellido = $('#segundoApellido').val();
        var dni = $('#dni').val();
        var telefono = $('#telefono').val();
        var sexo = $('#sexo').val();
        var fechaDeNacimiento = $('#fechaDeNacimiento').val();
        var edad = $('#edad').val();
        var direccion = $('#direccion').val();
        var correoElectronico = $('#correoElectronico').val();
        // Obtener el resto de los campos...

        // Realizar solicitud AJAX al controlador PHP
        $.ajax({
            type: 'POST',
            url: 'ControladorPersona.php',
            data: {
                accion: 'Actualizar Persona', // Indicador de acción para actualizar persona
                dni: dni, // DNI para identificar la persona
                primerNombre: primerNombre,
                segundoNombre: segundoNombre,
                primerApellido: primerApellido,
                segundoApellido: segundoApellido,
                dni: dni,
                telefono: telefono,
                sexo: sexo,
                fechaDeNacimiento: fechaDeNacimiento,
                edad: edad,
                direccion: direccion,
                correoElectronico: correoElectronico,
                // Resto de los campos actualizados...
            },
            success: function(response) {
                // Mostrar un mensaje de éxito o manejar la respuesta
                alert(response); // Puedes mostrar una alerta, por ejemplo
            },
            error: function(xhr, status, error) {
                // Manejar errores si la solicitud falla
                console.error(error);
                alert("Hubo un error al actualizar la persona.");
            }
        });
    });
});
        </script>
    <hr>
</body>
</html>
