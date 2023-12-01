<?php
include 'DAOExpedientes.php';
include 'Expediente.php';
$DaoExp = new DAOExpedientes();
$exp = new Expediente();
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
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de expedientes</h2>

        <form action="./FormularioExpediente.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                <input type="hidden" name="id_expediente" id="id_expediente" value="<?php echo isset($_GET['id_expediente']) ? $_GET['id_expediente'] : ''; ?>">

                <label for="id_paciente">Paciente</label>
                <?php
                echo $DaoExp->getPacientes();
                ?>

                <label for="id_doctor">Doctor</label>
                <?php
                echo $DaoExp->getMedicos();
                ?>

                <div class="form-floating my-4">
                    <textarea class="form-control" id="diagnostico" name="diagnostico" style="height: 100px">
<?php echo isset($_GET['diagnostico']) ? $_GET['diagnostico'] : ''; ?>
                    </textarea>
                    <label for="diagnostico">Diagnóstico</label>
                </div>

                <div class="form-floating my-4">
                    <textarea class="form-control" id="tratamiento" name="tratamiento" style="height: 100px">
<?php echo isset($_GET['tratamiento']) ? $_GET['tratamiento'] : ''; ?>
                    </textarea>
                    <label for="tratamiento">Tratamiento</label>
                </div>

                <div class="form-floating my-4">
                    <textarea class="form-control" id="observaciones" name="observaciones" style="height: 100px">
<?php echo isset($_GET['observaciones']) ? $_GET['observaciones'] : ''; ?>
                    </textarea>
                    <label for="observaciones">Observaciones</label>
                </div>

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
        $exp->setIdPaciente($_REQUEST["id_paciente"]);
        $exp->setIdMedico($_REQUEST["id_doctor"]);
        $exp->setDianostico($_REQUEST["diagnostico"]);
        $exp->setTratamiento($_REQUEST["tratamiento"]);
        $exp->setObservaciones($_REQUEST["observaciones"]);
        $DaoExp->ingresarExpediente($exp);
    } elseif (isset($_REQUEST["btnModificar"])) {
        $exp->setIdExpediente($_REQUEST["id_expediente"]);
        $exp->setIdPaciente($_REQUEST["id_paciente"]);
        $exp->setIdMedico($_REQUEST["id_doctor"]);
        $exp->setDianostico($_REQUEST["diagnostico"]);
        $exp->setTratamiento($_REQUEST["tratamiento"]);
        $exp->setObservaciones($_REQUEST["observaciones"]);
        $DaoExp->actualizarExpediente($exp);
    } elseif (isset($_REQUEST["btnEliminar"])) {
        $exp->setIdExpediente($_REQUEST["id_expediente"]);
        $DaoExp->eliminarExpediente($exp);
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
                if ((input.value === "") && (input.id !== "id_expediente")) {
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
            window.location.href = "TablaExpedientes.php";
        }
    </script>

</body>

</html>