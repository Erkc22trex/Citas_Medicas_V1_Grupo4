<?php
include_once 'DAOUsuario.php';
include_once 'Usuario.php';
$DaoUsr = new DAOUsuario();
$usr = new Usuario();
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        #id_doctor,
        #id_recepcionista, #medicos, #recepcionistas {
            display: none;
        }
    </style>
</head>

<body>
    <section>
        <div class="px-5 py-2">
            <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary" onclick="return regresar()">atras</button>
        </div>
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de usuarios</h2>

        <form action="./FormularioUsuario.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo isset($_GET['id_usuario']) ? $_GET['id_usuario'] : ''; ?>">
                <input type="hidden" name="id_persona" id="id_persona" value="<?php echo isset($_GET['id_persona']) ? $_GET['id_persona'] : ''; ?>">


                <div class="mb-3">
                    <label id="valuetoggleSelect" for="toggleSelect">Mostrar Médicos</label>
                    <input type="checkbox" id="toggleSelect" onchange="toggleSelects()">
                </div>


                <label id="medicos" for="medicos">Médicos</label>
                <?php
                echo $DaoUsr->getMedicos();
                ?>

                <label id="recepcionistas" for="recepcionistas">Recepcionistas</label>
                <?php
                echo $DaoUsr->getRecepcionistas();
                ?>

                <!-- <label for="correo">Correo</label>
                <input type="text" class="form-control" id="correo" name="correo" value="<?php echo isset($_GET['correo']) ? $_GET['correo'] : ''; ?>"> -->

                <label for="rol">Rol</label>
                <select class="form-select" id="rol" name="rol" aria-label="Default select example">
                    <option <?php echo (!isset($_GET['rol']) || $_GET['rol'] === 'Seleccione un rol') ? 'selected' : ''; ?>>Seleccione un rol</option>
                    <option value="Admin" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'Admin') ? 'selected' : ''; ?>>Administrador</option>
                    <option value="Doctor" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'Doctor') ? 'selected' : ''; ?>>Doctor</option>
                    <option value="Recepcionista" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'Recepcionista') ? 'selected' : ''; ?>>Recepcionista</option>
                    <!-- <option value="Paciente" <?php echo (isset($_GET['rol']) && $_GET['rol'] === 'Paciente') ? 'selected' : ''; ?>>Paciente</option> -->
                </select>


                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" value="<?php echo isset($_GET['password']) ? $_GET['password'] : ''; ?>">

                <label for="estado">Estado</label>
                <select class="form-select" id="estado" name="estado" aria-label="Default select example">
                    <option <?php echo (!isset($_GET['estado']) || $_GET['estado'] === 'Seleccione un estado') ? 'selected' : ''; ?>>Seleccione un estado</option>
                    <option value="Activo" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Activo') ? 'selected' : ''; ?>>Activo</option>
                    <option value="Inactivo" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                </select>

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
        // $usr->setDni($_REQUEST["dni"]);
        // $usr->setNombre($_REQUEST["nombre"]);
        // $usr->setApellido($_REQUEST["apellido"]);
        // $usr->setTelefono($_REQUEST["telefono"]);
        // $usr->setEdad($_REQUEST["edad"]);
        // $usr->setSexo($_REQUEST["sexo"]);
        // $usr->setFechaNacimiento($_REQUEST["fecha_nacimiento"]);
        // $usr->setDireccion($_REQUEST["direccion"]);
        // $usr->setCorreo($_REQUEST["correo"]);

        if(isset($_REQUEST["id_doctor"])) {
            $usr->setIdPersona($_REQUEST["id_doctor"]);
        } else {
            $usr->setIdPersona($_REQUEST["id_recepcionista"]);
        }
        // $usr->setIdPersona($_REQUEST["id_persona"]);
        $usr->setRol($_REQUEST["rol"]);
        $usr->setPassword($_REQUEST["password"]);
        $usr->setEstado($_REQUEST["estado"]);
        $DaoUsr->ingresarUsuario($usr);
    } elseif (isset($_REQUEST["btnModificar"])) {

        if(isset($_REQUEST["id_doctor"])) {
            $usr->setIdPersona($_REQUEST["id_doctor"]);
        } else {
            $usr->setIdPersona($_REQUEST["id_recepcionista"]);
        }

        // $usr->setIdPersona($_REQUEST["id_persona"]);
        $usr->setIdUsuario($_REQUEST["id_usuario"]);
        // $usr->setDni($_REQUEST["dni"]);
        // $usr->setNombre($_REQUEST["nombre"]);
        // $usr->setApellido($_REQUEST["apellido"]);
        // $usr->setTelefono($_REQUEST["telefono"]);
        // $usr->setEdad($_REQUEST["edad"]);
        // $usr->setSexo($_REQUEST["sexo"]);
        // $usr->setFechaNacimiento($_REQUEST["fecha_nacimiento"]);
        // $usr->setDireccion($_REQUEST["direccion"]);
        // $usr->setCorreo($_REQUEST["correo"]);
        $usr->setRol($_REQUEST["rol"]);
        $usr->setPassword($_REQUEST["password"]);
        $usr->setEstado($_REQUEST["estado"]);
        $DaoUsr->actualizarUsuario($usr);
    } elseif (isset($_REQUEST["btnEliminar"])) {

        if(isset($_REQUEST["id_doctor"])) {
            $usr->setIdPersona($_REQUEST["id_doctor"]);
        } else {
            $usr->setIdPersona($_REQUEST["id_recepcionista"]);
        }

        // $usr->setIdPersona($_REQUEST["id_persona"]);
        $usr->setIdUsuario($_REQUEST["id_usuario"]);
        $usr->setDni($_REQUEST["dni"]);
        $DaoUsr->eliminarUsuario($usr);
    }
    ?>

    <script>
        function validar() {
            // Obtener el formulario
            const form = document.getElementById("formulario1");

            // Comprobar que todos los campos estén rellenos
            const inputs = form.querySelectorAll("input");
            for (const input of inputs) {
                if ((input.value === "") && (input.id !== "id_usuario") && (input.id !== "id_persona") && (input.id !== "password")) {
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
            window.location.href = "TablaUsuarios.php";
        }

        function toggleSelects() {
            var checkBox = document.getElementById("toggleSelect");
            var selectMedicos = document.getElementById("id_doctor");
            var selectRecepcionistas = document.getElementById("id_recepcionista");
            var label = document.getElementById("medicos");
            var label2 = document.getElementById("recepcionistas");
            var labelToggle = document.getElementById("valuetoggleSelect");

            if (checkBox.checked) {
                selectMedicos.style.display = "block"; // Muestra el select de médicos
                selectRecepcionistas.style.display = "none"; // Oculta el select de recepcionistas

                label.style.display = "block"; // Muestra el label de médicos
                label2.style.display = "none"; // Oculta el label de recepcionistas

                labelToggle.innerHTML = "Mostrar Recepcionistas";

            } else {
                selectMedicos.style.display = "none"; // Oculta el select de médicos
                selectRecepcionistas.style.display = "block"; // Muestra el select de recepcionistas

                label.style.display = "none"; // Oculta el label de médicos
                label2.style.display = "block"; // Muestra el label de recepcionistas

                labelToggle.innerHTML = "Mostrar Médicos";
            }
        }
    </script>

</body>

</html>