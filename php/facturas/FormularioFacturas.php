<?php
include 'detalle_factura/DAODetFac.php';
include 'Factura.php';
include 'DAOFacturas.php';

$fac = new Factura();
$DaoFac = new DAOFacturas();
$DaoDetFac = new DAODetFac();
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
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de factura</h2>

        <form action="./FormularioFacturas.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 900px;">
            <input type="hidden" name="id_factura" id="id_factura" value="<?php echo isset($_GET['id_factura']) ? $_GET['id_factura'] : ''; ?>">

            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="id_cita">Cita</label>
                            <?php
                            echo $DaoFac->getCita();
                            ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="id_medico">Médicos</label>
                            <?php
                            echo $DaoFac->getMedicos();
                            ?>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="id_medico">Paciente</label>
                            <?php
                            echo $DaoFac->getPaciente();
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="estado">Estado</label>
                            <select class="form-select" id="estado" name="estado" aria-label="Default select example">
                                <option <?php echo (!isset($_GET['estado']) || $_GET['estado'] === 'Seleccione un estado') ? 'selected' : ''; ?>>Seleccione un estado</option>
                                <option value="Pendiente" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="Pagada" <?php echo (isset($_GET['estado']) && $_GET['estado'] === 'Pagada') ? 'selected' : ''; ?>>Pagada</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="tipo_pago">Tipo de pago</label>
                            <select class="form-select" id="tipo_pago" name="tipo_pago" aria-label="Default select example">
                                <option <?php echo (!isset($_GET['tipo_pago']) || $_GET['tipo_pago'] === 'Seleccione un tipo_pago') ? 'selected' : ''; ?>>Seleccione un tipo_pago</option>
                                <option value="Cheque" <?php echo (isset($_GET['tipo_pago']) && $_GET['tipo_pago'] === 'Cheque') ? 'selected' : ''; ?>>Cheque</option>
                                <option value="Efectivo" <?php echo (isset($_GET['tipo_pago']) && $_GET['tipo_pago'] === 'Efectivo') ? 'selected' : ''; ?>>Efectivo</option>
                                <option value="Transferencia" <?php echo (isset($_GET['tipo_pago']) && $_GET['tipo_pago'] === 'Transferencia') ? 'selected' : ''; ?>>Transferencia</option>
                                <option value="Tarjeta de debito" <?php echo (isset($_GET['tipo_pago']) && $_GET['tipo_pago'] === 'Tarjeta de debito') ? 'selected' : ''; ?>>Tarjeta de débito</option>
                                <option value="Tarjeta de credito" <?php echo (isset($_GET['tipo_pago']) && $_GET['tipo_pago'] === 'Tarjeta de credito') ? 'selected' : ''; ?>>Tarjeta de crédito</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="fecha_Emision">Fecha emisión</label>
                            <input type="date" class="form-control" id="fecha_Emision" name="fecha_Emision" value="<?php echo isset($_GET['fecha_Emision']) ? $_GET['fecha_Emision'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label for="monto_total">Monto total</label>
                            <input type="number" class="form-control" id="monto_total" min="700" name="monto_total" value="<?php echo isset($_GET['monto_total']) ? $_GET['monto_total'] : '700'; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between py-3">
                <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary">Agregar</button>
                <button type="submit" id="btnModificar" name="btnModificar" class="btn btn-danger">Modificar</button>
                <button type="submit" id="btnEliminar" name="btnEliminar" class="btn btn-dark">Eliminar</button>
            </div>
        </form>


        <div style="position: relative; margin: auto; width: 900px;">
            <div class="py-3 d-flex flex-row-reverse">
                <button id="btnAgregarDetFac" class="btn btn-primary" onclick="return agregarDetalleFactura()">
                    agregar detalle factura
                </button>
            </div>
            <?php
            echo $DaoDetFac->getTabla(isset($_GET['id_factura']) ? $_GET['id_factura'] : '');
            ?>
        </div>

    </section>

    <?php
    if (isset($_REQUEST["btnAgregar"])) {
        $fac->setIdCita($_REQUEST["id_cita"]);
        $fac->setEstado($_REQUEST["estado"]);
        $fac->setTipoPago($_REQUEST["tipo_pago"]);
        $fac->setFechaEmision($_REQUEST["fecha_Emision"]);
        $fac->setMontoTotal($_REQUEST["monto_total"]);
        $DaoFac->ingresarFactura($fac);
    } elseif (isset($_REQUEST["btnModificar"])) {
        $fac->setIdFactura($_REQUEST["id_factura"]);
        $fac->setIdCita($_REQUEST["id_cita"]);
        $fac->setEstado($_REQUEST["estado"]);
        $fac->setTipoPago($_REQUEST["tipo_pago"]);
        $fac->setFechaEmision($_REQUEST["fecha_Emision"]);
        $fac->setMontoTotal($_REQUEST["monto_total"]);
        $fac->setEstado($_REQUEST["estado"]);
        $DaoFac->actualizarFactura($fac);
    } elseif (isset($_REQUEST["btnEliminar"])) {
        $fac->setIdFactura($_REQUEST["id_factura"]);
        $DaoFac->eliminarFactura($fac);
    }
    ?>

    <script>
        function validar() {
            // Obtener el formulario
            const form = document.getElementById("formulario1");

            // Comprobar que los selects no estén vacíos
            const selects = form.querySelectorAll("select");
            for (const select of selects) {
                if ((select.value === "") && (input.id !== "id_doctor") && (input.id !== "id_paciente")) {
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
                if ((input.value === "") && (input.id !== "id_factura")) {
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
            window.location.href = "TablaFacturas.php";
        }

        function seleccionarDetalleFactura(id_det_Factura, id_factura, descripcion, precio) {
            window.location.href = './detalle_factura/FormularioDetFac.php?id_det_Factura=' + id_det_Factura +
                '&id_factura=' + id_factura +
                '&descripcion=' + descripcion +
                '&precio=' + precio;
        }

        function agregarDetalleFactura() {
            window.location.href = "./detalle_factura/FormularioDetFac.php?id_factura=" + document.getElementById("id_factura").value;
        }

    </script>

</body>

</html>