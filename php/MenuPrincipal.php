<!DOCTYPE html>
<html>
<head>
  <title>Menú Principal</title>
  <!-- Enlaces a Bootstrap y CSS personalizado -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilos adicionales personalizados */
    body {
      padding-bottom: 60px; /* Agregamos un espacio en la parte inferior para los botones */
      font-family: Arial, sans-serif;
    }

    h1 {
      text-align: center;
      margin-top: 20px;
    }

    /* Estilo para los botones */
    .menu-button {
      margin: 5px;
    }

    /* Estilo para el footer */
    .footer-buttons {
      position: fixed;
      bottom: 0;
      width: 100%;
      background-color: #f8f9fa; /* Color de fondo */
      padding: 10px 0; /* Espaciado interno */
      text-align: center; /* Centrar el contenido */
    }
  </style>
</head>
<body>
  <h1>Bienvenido al Sistema de Gestión Clínica</h1>

  <!-- Contenedor de los botones -->
  <div class="d-grid gap-2">
    <!-- Botones con clases de Bootstrap -->
    <button class="btn btn-primary btn-sm menu-button" onclick="vistaPersona()">CRUD PACIENTE</button>
    <button class="btn btn-secondary btn-sm menu-button" onclick="VistaPaciente()">CRUD ADMINISTRADOR</button>
    <button class="btn btn-success btn-sm menu-button" onclick="VistaMedico()">CRUD MEDICO</button>
    <!-- <button class="btn btn-danger btn-sm menu-button" onclick="eliminarPaciente()">Eliminar Paciente</button> -->
  </div>

  <!-- Footer para los botones -->
  <div class="footer-buttons">
    <!-- Coloca los botones en la parte inferior -->
    <button class="btn btn-primary btn-sm menu-button" onclick="vistaPersona()">CRUD PACIENTE</button>
    <button class="btn btn-secondary btn-sm menu-button" onclick="VistaPaciente()">CRUD ADMINISTRADOR</button>
    <button class="btn btn-success btn-sm menu-button" onclick="VistaMedico()">CRUD MEDICO</button>
    <!-- <button class="btn btn-danger btn-sm menu-button" onclick="eliminarPaciente()">Eliminar Paciente</button> -->
  </div>

  <!-- Scripts -->
  <script>
    function vistaPersona() {
      window.location.href = 'vistaPersona.php';
    }

//    function buscarPaciente() {
//      console.log('Redirigir a la página de búsqueda de pacientes');
//    }
//
//    function actualizarPaciente() {
//      console.log('Redirigir a la página de actualización de pacientes');
//    }
//
//    function eliminarPaciente
</SCRIPT>
</body>
</html>