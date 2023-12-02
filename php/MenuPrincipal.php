<!DOCTYPE html>
<html>

<head>
  <title>Menú Principal</title>
  <!-- Enlaces a Bootstrap y CSS personalizado -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>

  <main class="d-flex flex-column vh-100" style="background-color: #C9F2EE;">

    <div class="custon-bg mb-2">
      <h1 class="text-center text-white py-4">Bienvenido al Sistema de Gestión Clínica</h1>
    </div>

    <div class="d-flex justify-content-center align-items-center">
      <img src="../styles/logo.jpeg" class="" alt="logo citas" style="width: 250px; height: 250px;">
    </div>

    <div class="container text-center px-5">
      <div class="row py-4">
        <div class="col">
          <button class="btn btn-primary btn-sm menu-button custon-btn w-100" onclick="return vistaPacientes()">PACIENTES</button>
        </div>
        <div class="col">
          <button class="btn btn-secondary btn-sm menu-button custon-btn w-100" onclick="return vistaRecepcionistas()">RECEPCIONISTAS</button>
        </div>
        <div class="col">
          <button class="btn btn-success btn-sm menu-button custon-btn w-100" onclick="return vistaMedicos()">MEDICOS</button>
        </div>
      </div>
      <div class="row py-4">
        <div class="col">
          <button class="btn btn-primary btn-sm menu-button custon-btn w-100" onclick="return vistaCitas()">CITAS</button>
        </div>
        <div class="col">
          <button class="btn btn-success btn-sm menu-button custon-btn w-100" onclick="return vistaFacturas()">FACTURAS</button>
        </div>
        <div class="col">
          <button class="btn btn-primary btn-sm menu-button custon-btn w-100" onclick="return vistaUsuarios()">USUARIOS</button>
        </div>
      </div>
      <div class="row py-4">
        <div class="col">
          <button class="btn btn-primary btn-sm menu-button custon-btn w-100" onclick="return vistaExpedientes()">EXPEDIENTES</button>
        </div>
        <div class="col">
          <button class="btn btn-primary btn-sm menu-button custon-btn w-100" onclick="return vistaExpedientes()">ESTADISTICAS</button>
        </div>
        <div class="col">
          <button class="btn btn-primary btn-sm menu-button custon-btn w-100" onclick="return cerrarSesion()">CERRAR SESIÓN</button>
        </div>
      </div>
    </div>
  </main>


  <!-- Scripts -->
  <script>
    function vistaExpedientes() {
      window.location.href = "expedientes/TablaExpedientes.php";
    }

    function vistaPacientes() {
      window.location.href = "pacientes/TablaPacientes.php";
    }

    function vistaRecepcionistas() {
      window.location.href = "recepcionistas/TablaRecepcionistas.php";
    }

    function vistaMedicos() {
      window.location.href = "medicos/TablaMedicos.php";
    }

    function vistaCitas() {
      window.location.href = "citas/TablaCitas.php";
    }

    function vistaFacturas() {
      window.location.href = "facturas/TablaFacturas.php";
    }

    function vistaUsuarios() {
      window.location.href = "usuarios/TablaUsuarios.php";
    }

    function cerrarSesion() {
      Swal.fire({
        title: '¿Está seguro que desea cerrar sesión?',
        text: "Se cerrará la sesión actual",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33'
      }).then((result) => {
        if (result.isConfirmed) {
          localStorage.removeItem('correo');
          localStorage.removeItem('rol');
          localStorage.removeItem('id_persona');

          window.location.href = "./login/login.php";
        }
      })
    }
  </SCRIPT>
</body>

</html>