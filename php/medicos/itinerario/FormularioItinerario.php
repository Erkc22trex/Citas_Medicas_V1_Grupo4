<?php
include 'DAOItinerarios.php';
include 'Itinerario.php';
$DaoItn = new DAOItinerarios();
$itn = new Itinerario();
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../../styles/styles.css">
</head>

<body>
    <section>
        <div class="px-5 py-2">
            <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary custon-btn" onclick="return regresar()">atras</button>
        </div>
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de itinerario</h2>

        <form action="./FormularioItinerario.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                <input type="hidden" name="id_medico" id="id_medico" value="<?php echo isset($_GET['id_medico']) ? $_GET['id_medico'] : ''; ?>">
                <input type="hidden" name="id_itinerario" id="id_itinerario" value="<?php echo isset($_GET['id_itinerario']) ? $_GET['id_itinerario'] : ''; ?>">

                <label for="doctor">Doctor</label>
                <?php
                echo $DaoItn->getMedicos();
                ?>

                <label for="hora_entrada">Hora entrada</label>
                <input type="time" class="form-control" id="hora_entrada" name="hora_entrada" value="<?php echo isset($_GET['hora_entrada']) ? $_GET['hora_entrada'] : ''; ?>">

                <label for="hora_salida">Hora salida</label>
                <input type="time" class="form-control" id="hora_salida" name="hora_salida" value="<?php echo isset($_GET['hora_salida']) ? $_GET['hora_salida'] : ''; ?>">
            </div>

            <div class="d-flex justify-content-between py-3">
                <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary custon-btn">Agregar</button>
                <button type="submit" id="btnModificar" name="btnModificar" class="btn btn-danger custon-btn">Modificar</button>
                <button type="submit" id="btnEliminar" name="btnEliminar" class="btn btn-dark custon-btn">Eliminar</button>
            </div>
        </form>

    </section>

    <?php
    $foot = "<section style='position: relative; margin: auto; width: 900px;'>";
    if (isset($_REQUEST["btnAgregar"])) {
        $itn->setIdMedico($_REQUEST["id_medico"]);
        $itn->setHoraEntrada($_REQUEST["hora_entrada"]);
        $itn->setHoraSalida($_REQUEST["hora_salida"]);
        $DaoItn->ingresarItinerario($itn);
    } elseif (isset($_REQUEST["btnModificar"])) {
        $itn->setIdItinerario($_REQUEST["id_itinerario"]);
        $itn->setIdMedico($_REQUEST["id_medico"]);
        $itn->setHoraEntrada($_REQUEST["hora_entrada"]);
        $itn->setHoraSalida($_REQUEST["hora_salida"]);
        $DaoItn->actualizarItinerario($itn);
    } elseif (isset($_REQUEST["btnEliminar"])) {
        $itn->setIdItinerario($_REQUEST["id_itinerario"]);
        $itn->setIdMedico($_REQUEST["id_medico"]);
        $DaoItn->eliminarItinerario($itn);
    }
    ?>

    <script>
        function validar() {
            // Obtener el formulario
            const form = document.getElementById("formulario1");

            // Comprobar que todos los campos estén rellenos
            const inputs = form.querySelectorAll("input");
            for (const input of inputs) {
                if ((input.value === "") && (input.id !== "id_itinerario") && (input.id !== "id_medico")) {
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
            window.location.href = './TablaItinerarios.php?id_medico=' + document.getElementById("id_medico").value;
        }
    </script>

</body>

</html>