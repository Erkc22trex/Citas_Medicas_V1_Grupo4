<!DOCTYPE html>
<html>
<head>
  <title>Menú Principal</title>
  <!-- Enlaces a Bootstrap y CSS personalizado -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilos adicionales personalizados */
    body {
      padding: 20px;
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center;
    }

    /* Estilo para los botones */
    .menu-button {
      margin: 5px;
    }
  </style>
</head>
<body>
  <h1>Bienvenido al Sistema de Gestión Clínica</h1>
  
  <div class="d-grid gap-2">
    <!-- Botones con clases de Bootstrap -->
    <button class="btn btn-primary menu-button" onclick="vistaPersona()">PACIENTE</button>
    <button class="btn btn-secondary menu-button" onclick="VistaPaciente()"></button>
    <button class="btn btn-success menu-button" onclick="VistaMedico()">CRUD MEDICO</button>
    <!-- <button class="btn btn-danger menu-button" onclick="eliminarPaciente()">Eliminar Paciente</button> -->
  </div>

  <!-- Scripts -->

  <script>
    function vistaPersona() {
      // Aquí podrías redirigir a la página de ingreso de un paciente
      // Por ejemplo: window.location.href = 'ingresar_paciente.html';
      window.location.href = 'vistaPersona.php';
    }

    function buscarPaciente() {
      // Aquí podrías redirigir a la página de búsqueda de pacientes
      // Por ejemplo: window.location.href = 'buscar_paciente.html';
      console.log('Redirigir a la página de búsqueda de pacientes');
    }

    function actualizarPaciente() {
      // Aquí podrías redirigir a la página de actualización de pacientes
      // Por ejemplo: window.location.href = 'actualizar_paciente.html';
      console.log('Redirigir a la página de actualización de pacientes');
    }

    function eliminarPaciente() {
      // Aquí podrías redirigir a la página de eliminación de pacientes
      // Por ejemplo: window.location.href = 'eliminar_paciente.html';
      console.log('Redirigir a la página de eliminación de pacientes');
    }
  </script>
</body>
</html>

