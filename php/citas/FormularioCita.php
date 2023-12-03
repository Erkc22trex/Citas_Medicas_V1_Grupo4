<?php
include 'DAOCitas.php';
include 'Cita.php';
$DaoCit = new DAOCitas();
$cta = new Cita();

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
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de citas</h2>

        <form action="./FormularioCita.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                <input type="hidden" name="id_cita" id="id_cita" value="<?php echo isset($_GET['id_cita']) ? $_GET['id_cita'] : ''; ?>">

                <label for="id_paciente">Paciente</label>
                <?php
                   echo $DaoCit->getPacientes();
                ?>

                <label for="id_doctor">Doctor</label>
                <?php
                   echo $DaoCit->getMedicos();
                ?>

                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo isset($_GET['fecha']) ? $_GET['fecha'] : ''; ?>">

                <label for="hora">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo isset($_GET['hora']) ? $_GET['hora'] : ''; ?>">

                <label for="estado">Estado</label>
                <select class="form-select" id="estado" name="estado" aria-label="Default select example">
                    <option <?php echo (!isset($_GET['estado']) || $_GET['estado'] === 'Seleccione un estado') ? 'selected' : ''; ?>>Seleccione un estado</option>
                    <option value="Pendiente" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Cancelada" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                    <option value="Finalizada" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Finalizada') ? 'selected' : ''; ?>>Finalizada</option>
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
    if (isset($_REQUEST["btnAgregar"])) {
        $cta->setIdPaciente($_REQUEST["id_paciente"]);
        $cta->setIdMedico($_REQUEST["id_doctor"]);
        $cta->setFecha($_REQUEST["fecha"]);
        $cta->setHora($_REQUEST["hora"]);
        $cta->setEstado($_REQUEST["estado"]);
        $DaoCit->ingresarCita($cta);
    } elseif (isset($_REQUEST["btnModificar"])) {
        $cta->setIdCita($_REQUEST["id_cita"]);
        $cta->setIdPaciente($_REQUEST["id_paciente"]);
        $cta->setIdMedico($_REQUEST["id_doctor"]);
        $cta->setFecha($_REQUEST["fecha"]);
        $cta->setHora($_REQUEST["hora"]);
        $cta->setEstado($_REQUEST["estado"]);
        $DaoCit->actualizarCita($cta);
    } elseif (isset($_REQUEST["btnEliminar"])) {
        $cta->setIdCita($_REQUEST["id_cita"]);
        $DaoCit->eliminarCita($cta);
    }
    ?>

    <script>
        function validar() {
            // Obtener el formulario
            const form = document.getElementById("formulario1");

            // Comprobar que los selects no estén vacíos
            const selects = form.querySelectorAll("select");
            for (const select of selects) {
                if (select.value === "") {
                    // Mostrar un sweet alert
                    Swal.fire({
                        title: "Error",
                        text: "El campo " + select.id + " es obligatorio",
                        icon: "error",
                        buttons: ["Aceptar"]
                    });
                    return false;
                }
            }

            // Comprobar que los inputs no estén vacíos
            const inputs = form.querySelectorAll("input");
            for (const input of inputs) {
                if ((input.value === "") && (input.id !== "id_cita")) {
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
            window.location.href = "TablaCitas.php";
        }
    </script>

</body>

</html>