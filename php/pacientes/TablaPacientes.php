<?php
include_once 'DAOPacientes.php';
include_once 'Paciente.php';
$DaoPac = new DAOPacientes();
$pac = new Paciente();
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <section class="d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-center">Pacientes</h2>

        <!-- formulario para búsquedas -->
        <form action="/Citas_Medicas_V1_Grupo4/php/pacientes/TablaPacientes.php" class="" method="post" name="formulario2" id="formulario2" onsubmit="">

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
                            <option value="codigo">Código</option>
                            <option value="nombre">Nombre</option>
                            <option value="dni">Identidad</option>
                        </select>
                    </div>
                </div>
                <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-secondary" onclick="return validar2()">Buscar</button>
                <button type="submit" id="btnQuitarF" name="btnQuitarF" class="btn btn-success" onclick="return recargar()">Quitar filtro</button>
            </div>
        </form>
    </section>
    <div class="d-flex justify-content-end align-items-center me-5 pe-2 mb-3">
        <button type="submit" id="btnAgregarPac" name="btnAgregarPac" class="btn btn-success" onclick="return agregarPaciente('agregar')">Agregar paciente</button>
    </div>
    <?php
    $foot = "<section class='p-5 overflow-auto' style='max-height: 500px;'>";
    if (isset($_REQUEST["btnBuscar"])) {
        $v1 = $_REQUEST["buscar"];
        $v2 = $_REQUEST["criterio"];

        echo $DaoPac->filtrarPaciente($v1, $v2);
    } else {
        echo $foot . $DaoPac->getTabla() . "</section>";
    }
    ?>

    <script>
        function seleccionar(accion, id_paciente, id_persona, dni, nombre, apellido, telefono, edad, sexo, fecha_nacimiento, direccion, correo) {
            window.location.href = 'http://localhost/Citas_Medicas_V1_Grupo4/php/pacientes/formularioPaciente.php?id_paciente=' + id_paciente +
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

        function agregarPaciente(accion) {
            window.location.href = 'http://localhost/Citas_Medicas_V1_Grupo4/php/pacientes/formularioPaciente.php?accion=' + accion;
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
    </script>
</body>

</html>