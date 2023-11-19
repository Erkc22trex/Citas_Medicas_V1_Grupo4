<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administrar Personas</title>
     <link rel="stylesheet" href="formularioPersona.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Ingresar Persona</h2>
     <form id="formularioPersona" action="ControladorPersona.php" method="post" style="position: relative; margin: auto; width: 500px;">
    <div class="mb-3">
        <label for="primerNombre" class="form-label">Primer Nombre:</label>
        <input type="text" class="form-control" id="primerNombre" name="primerNombre" required><br><br>
    </div>

    <div class="mb-3">
        <label for="segundoNombre" class="form-label">Segundo Nombre:</label>
        <input type="text" class="form-control" id="segundoNombre" name="segundoNombre"><br><br>
    </div>

    <div class="mb-3">
        <label for="primerApellido" class="form-label">Primer Apellido:</label>
        <input type="text" class="form-control" id="primerApellido" name="primerApellido" required><br><br>
    </div>

    <div class="mb-3">
        <label for="segundoApellido" class="form-label">Segundo Apellido:</label>
        <input type="text" class="form-control" id="segundoApellido" name="segundoApellido"><br><br>
    </div>

    <div class="mb-3">
        <label for="dni" class="form-label">DNI:</label>
        <input type="text" class="form-control" id="dni" name="dni" required><br><br>
    </div>

    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono:</label>
        <input type="text" class="form-control" id="telefono" name="telefono" required><br><br>
    </div>

    <div class="mb-3">
        <label for="sexo" class="form-label">Sexo:</label>
        <input type="text" class="form-control" id="sexo" name="sexo" required><br><br>
    </div>

    <div class="mb-3">
        <label for="fechaDeNacimiento" class="form-label">Fecha de Nacimiento:</label>
        <input type="text" class="form-control" id="fechaDeNacimiento" name="fechaDeNacimiento" required><br><br>
    </div>

    <div class="mb-3">
        <label for="edad" class="form-label">Edad:</label>
        <input type="number" class="form-control" id="edad" name="edad" required><br><br>
    </div>

    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección:</label>
        <input type="text" class="form-control" id="direccion" name="direccion" required><br><br>
    </div>

    <div class="mb-3">
        <label for="correoElectronico" class="form-label">Correo Electrónico:</label>
        <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required><br><br>
    </div>

    <div class="botones">
        <input type="submit" class="btn btn-primary" name="accion" value="Insertar Persona">
        <input type="submit" class="btn btn-primary" name="accion" value="Ver Persona">
        <input type="submit" class="btn btn-primary" name="accion" value="Actualizar Persona">
        <input type="submit" class="btn btn-primary" name="accion" value="Eliminar Persona">
    </div>
</form>
<!-- formulario para búsquedas --> 
              <form action="ControladorPersona.php" method="post" name = "formulario2" id = "formulario2" onsubmit="" style="position: relative; margin: auto; width: 500px;">
                <div class="mb-1">
                    <label for="busqueda">Buscar: </label>
                    <input type="text" class="form-control" id="buscar" name="buscar" >                
                    <label for="dni">Buscar por: </label>
                    <table>
                        <tr><td><select class="form-select" id="dni" name="dni" style="width: 300px;">
                              <option value="primerNombre">Primer Nombre</option>
                              <option value="segundoNombre">Segundo Nombre</option>
                              <option value="primerApellido">Primer Apellido</option>
                              <option value="segundoApellido">Segundo Apellido</option>
                              <option value="dni">DNI</option>
                              <option value="telefono">Telefono</option>
                              <option value="sexo">Sexo</option>
                              <option value="fechaDeNacimiento">Fecha de Nacimiento</option>
                              <option value="edad">Edad</option>
                              <option value="direccion">Direccion</option>
                              <option value="correoElectornico">Correo Electronico</option>
                            </select>
                          </td> <td>
                              <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-primary" onclick="return validar2()">Buscar</button> </td><td>
                            <button type="submit" id="btnQuitarF" name="btnQuitarF" class="btn btn-success" onclick="return recargar()">Quitar filtro</button>
                          </td></tr></table> 
               </div>
            </form>

    <hr>

    <!-- Tabla para mostrar resultados de búsqueda -->
    <h2>Resultados de Búsqueda</h2>
    <div id="tablaResultados">
    </div>
     <script>
        $(document).ready(function() {
            $('#formularioPersona').on('submit', function(e) {
                e.preventDefault(); // Evitar que el formulario se envíe por defecto

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'ControladorPersona.php',
                    data: formData,
                    success: function(response) {
                        // Manejo de la respuesta del servidor
                        alert(response);

                        // Limpieza de los campos del formulario si es necesario
                         $('#formularioPersona')[0].reset();
                    }
                });
            });
        });
    </script>
</body>
</html>
