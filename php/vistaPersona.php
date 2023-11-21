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
        <input type="date" class="form-control" id="fechaDeNacimiento" name="fechaDeNacimiento" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">
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
       <!-- <input type="submit" class="btn btn-primary" name="accion" value="Actualizar Persona">
        <input type="submit" class="btn btn-primary" name="accion" value="Eliminar Persona">-->
    </div> 
</form>
  
<!-- formulario para búsquedas -->
              <form action="ControladorPersona.php" method="post" name="formulario2" id="formulario2" style="width: 200px; position: absolute; top: 10px; right: 10px;">
    <div class="mb-1">
        <label for="buscar">Buscar por DNI:</label>
        <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Ingrese DNI" >
    </div>
</form>

    <hr>
</body>
</html>
