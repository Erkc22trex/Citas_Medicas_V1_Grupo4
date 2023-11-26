<?php
include_once 'DAOPacientes.php';
include_once 'Paciente.php';
$DaoPac = new DAOPacientes();
$pac = new Paciente();
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <section>
        <div class="px-5 py-2">
            <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary" onclick="return regresar()">atras</button>
        </div>
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de paciente</h2>

        <form action="/Citas_Medicas_V1_Grupo4/php/pacientes/FormularioPaciente.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                <!-- <input type="hidden" name="accion" id="accion" value="<?php echo isset($_GET['accion']) ? $_GET['accion'] : ''; ?>"> -->
                <input type="hidden" name="id_paciente" id="id_paciente" value="<?php echo isset($_GET['id_paciente']) ? $_GET['id_paciente'] : ''; ?>">
                <input type="hidden" name="id_persona" id="id_persona" value="<?php echo isset($_GET['id_persona']) ? $_GET['id_persona'] : ''; ?>">
                
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" maxlength="100" value="<?php echo isset($_GET['dni']) ? $_GET['dni'] : ''; ?>">

                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($_GET['nombre']) ? $_GET['nombre'] : ''; ?>">

                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo isset($_GET['apellido']) ? $_GET['apellido'] : ''; ?>">

                <label for="telefono">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo isset($_GET['telefono']) ? $_GET['telefono'] : ''; ?>">

                <label for="edad">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" value="<?php echo isset($_GET['edad']) ? $_GET['edad'] : ''; ?>">

                <label for="sexo">sexo</label>
                <input type="text" class="form-control" id="sexo" name="sexo" value="<?php echo isset($_GET['sexo']) ? $_GET['sexo'] : ''; ?>">

                <label for="correo">Correo</label>
                <input type="text" class="form-control" id="correo" name="correo" value="<?php echo isset($_GET['correo']) ? $_GET['correo'] : ''; ?>">

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($_GET['fecha_nacimiento']) ? $_GET['fecha_nacimiento'] : ''; ?>">

                <label for="direccion">Direccion</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo isset($_GET['direccion']) ? $_GET['direccion'] : ''; ?>">
            </div>

            <div class="d-flex justify-content-between py-3">
                <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary">Agregar</button>
                <button type="submit" id="btnModificar" name="btnModificar" class="btn btn-danger">Modificar</button>
                <button type="submit" id="btnEliminar" name="btnEliminar" class="btn btn-dark">Eliminar</button>
            </div>
        </form>

    </section>

    <?php
    $foot = "<section style='position: relative; margin: auto; width: 900px;'>";
    if (isset($_REQUEST["btnAgregar"])) {
        $pac->setDni($_REQUEST["dni"]);
        $pac->setNombre($_REQUEST["nombre"]);
        $pac->setApellido($_REQUEST["apellido"]);
        $pac->setTelefono($_REQUEST["telefono"]);
        $pac->setEdad($_REQUEST["edad"]);
        $pac->setSexo($_REQUEST["sexo"]);
        $pac->setCorreo($_REQUEST["correo"]);
        $pac->setFechaNacimiento($_REQUEST["fecha_nacimiento"]);
        $pac->setDireccion($_REQUEST["direccion"]);
        $DaoPac->ingresarPaciente($pac);
    } elseif (isset($_REQUEST["btnModificar"])) {
        $pac->setIdPersona($_REQUEST["id_persona"]);
        $pac->setDni($_REQUEST["dni"]);
        $pac->setNombre($_REQUEST["nombre"]);
        $pac->setApellido($_REQUEST["apellido"]);
        $pac->setTelefono($_REQUEST["telefono"]);
        $pac->setEdad($_REQUEST["edad"]);
        $pac->setSexo($_REQUEST["sexo"]);
        $pac->setFechaNacimiento($_REQUEST["fecha_nacimiento"]);
        $pac->setCorreo($_REQUEST["correo"]);
        $pac->setDireccion($_REQUEST["direccion"]);
        $DaoPac->actualizarPaciente($pac);
    } elseif (isset($_REQUEST["btnEliminar"])) {
        $pac->setIdPersona($_REQUEST["id_persona"]);
        $pac->setIdPaciente($_REQUEST["id_paciente"]);
        $pac->setDni($_REQUEST["dni"]);
        $DaoPac->eliminarPaciente($pac);
    }
    ?>

    <script>

        function validar() {
            // Obtener el formulario
            const form = document.getElementById("formulario1");

            // Comprobar que todos los campos estén rellenos
            const inputs = form.querySelectorAll("input");
            for (const input of inputs) {
                if ((input.value === "") && (input.id !== "id_paciente") && (input.id !== "id_persona")) {
                    // Mostrar un sweet alert
                    Swal.fire({
                        title: "Error",
                        text: "El campo " + input.id + " es obligatorio",
                        icon: "error",
                        buttons: ["Aceptar"]
                    });
                    return false;
                }
            }
            return true;
        }

        function recargar() {
            location.reload();
        }

        function regresar() {
            window.location.href = "TablaPacientes.php";
        }
    </script>

</body>

</html>