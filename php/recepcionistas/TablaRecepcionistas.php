<?php
include_once 'DAORecepcionista.php';
include_once 'Recepcionista.php';
$Daorecp = new DAORecepcionista();
$recp = new Recepcionista();
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../styles/styles.css">
</head>

<body>
    <div class="px-5 py-2">
        <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary custon-btn" onclick="return regresar()">Inicio</button>
    </div>
    <section class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-center">Recepcionistas</h2>

        <!-- formulario para búsquedas -->
        <form action="./TablaRecepcionistas.php" class="" method="post" name="formulario2" id="formulario2" onsubmit="">

            <div class="d-flex justify-content-center align-items-center gap-4">

                <div class="row g-3 align-items-center py-3">
                    <div class="col-auto">
                        <label for="busqueda" class="col-form-label">Buscar:</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="buscar" name="buscar" class="form-control">
                    </div>
                </div>

                <div class="row g-3 align-items-center py-3">
                    <div class="col-auto">
                        <label for="criterio" class="col-form-label">Buscar por:</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="criterio" name="criterio">
                            <option value="recp.id_recepcionista">Código</option>
                            <option value="per.nombre">Nombre</option>
                            <option value="per.dni">Identidad</option>
                        </select>
                    </div>
                </div>
                <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-secondary" onclick="return validar2()">Buscar</button>
                <button type="submit" id="btnQuitarF" name="btnQuitarF" class="btn btn-success" onclick="return recargar()">Quitar filtro</button>
            </div>
        </form>
    </section>
    <div class="d-flex justify-content-end align-items-center me-5 pe-2 mb-3">
        <button type="submit" id="btnAgregarPac" name="btnAgregarPac" class="btn btn-success custon-btn" onclick="return agregarRecepcionista('agregar')">Agregar recepcionista</button>
    </div>
    <?php
    $foot = "<section class='p-5 overflow-auto' style='max-height: 500px;'>";
    if (isset($_REQUEST["btnBuscar"])) {
        $v1 = $_REQUEST["buscar"];
        $v2 = $_REQUEST["criterio"];
        echo $foot . $Daorecp->filtrarPaciente($v1, $v2) . "</section>";
    } else {
        echo $foot . $Daorecp->getTabla() . "</section>";
    }
    ?>

    <script>
        function seleccionar(accion, id_recepcionista, id_persona, dni, nombre, apellido, telefono, edad, sexo, fecha_nacimiento, direccion, correo) {
            window.location.href = './formularioRecepcionista.php?id_recepcionista=' + id_recepcionista +
                '&id_persona=' + id_persona +
                '&dni=' + dni +
                '&nombre=' + nombre +
                '&apellido=' + apellido +
                '&telefono=' + telefono +
                '&edad=' + edad +
                '&sexo=' + sexo +
                '&fecha_nacimiento=' + fecha_nacimiento +
                '&direccion=' + direccion +
                '&correo=' + correo +
                '&accion=' + accion;
        }

        function agregarRecepcionista(accion) {
            window.location.href = './formularioRecepcionista.php?accion=' + accion;
        }

        function validar2() {
            // Obtener el formulario
            const form = document.getElementById("formulario2");

            // Comprobar que todos los campos estén rellenos
            const inputs = form.querySelectorAll("input");
            for (const input of inputs) {
                if (input.value === "") {
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
            window.location.href = "./../MenuPrincipal.php";
        }
    </script>
</body>

</html>