<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Administración de Médicos</title>
  <link rel="stylesheet" href="styles.css"> <!-- Enlaza tu archivo CSS -->
</head>
<body>

  <h1>Administración de Médicos</h1>

  <h2>Agregar Médico</h2>
  <form action="procesar_agregar_medico.php" method="post">
    <label for="dni">DNI:</label>
    <input type="text" id="dni" name="dni" required><br><br>

    <label for="primerNombre">Primer Nombre:</label>
    <input type="text" id="primerNombre" name="primerNombre" required><br><br>
    
    <label for="segundoNombre">Segundo Nombre:</label>
    <input type="text" id="segundoNombre" name="segundoNombre"><br><br>

    <!-- Añade los demás campos necesarios -->

    <input type="submit" value="Agregar Médico">
  </form>

</body>
</html>
