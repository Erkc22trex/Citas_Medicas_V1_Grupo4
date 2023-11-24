<?php
include 'DAOPacientes.php';
include 'Paciente.php';
$P = new DAOPacientes();
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
        <h2 style="position: relative; margin: auto; width: 500px;">Formulario de pacientes</h2>

        <form action="/Citas_Medicas_V1_Grupo4/php/pacientes/vistaPacientes.php" method="post" name="formulario1" id="formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-3">
                <label for="codigo">Código</label>
                <input type="number" class="form-control" id="codigo" name="codigo" min="1" step="1">

                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" maxlength="100">

                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre">

                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido">

                <label for="telefono">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15">

                <label for="edad">Edad</label>
                <input type="number" class="form-control" id="edad" name="edad" maxlength="15">

                <label for="sexo">sexo</label>
                <input type="text" class="form-control" id="sexo" name="sexo" maxlength="15">

                <label for="correo">Correo</label>
                <input type="text" class="form-control" id="correo" name="correo" maxlength="15">

                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">

                <label for="direccion">Direccion</label>
                <input type="text" class="form-control" id="direccion" name="direccion">
            </div>
            <button type="submit" id="btnAgregar" name="btnAgregar" class="btn btn-primary">Agregar</button>
            <button type="submit" id="btnModificar" name="btnModificar" class="btn btn-danger" disabled>modificar</button>
            <button type="submit" id="btnEliminar" name="btnEliminar" class="btn btn-dark" disabled>Eliminar</button>
        </form>
        <br>
        <!-- formulario para búsquedas -->
        <form action="/ejemploDAOCRUD/vistaPersona.php" method="post" name="formulario2" id="formulario2" onsubmit="" style="position: relative; margin: auto; width: 500px;">
            <div class="mb-1">
                <label for="busqueda">Buscar: </label>
                <input type="text" class="form-control" id="buscar" name="buscar">
                <label for="criterio">Buscar por: </label>
                <table>
                    <tr>
                        <td>
                            <select class="form-select" id="criterio" name="criterio" style="width: 300px;">
                                <option value="codigo">Código</option>
                                <option value="nombre">Nombre completo</option>
                                <option value="id">Identidad</option>
                                <option value="nombreUsuario">Nombre de usuario</option>
                            </select>
                        </td>
                        <td>
                            <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-secondary" onclick="return validar2()">Buscar</button>
                        </td>
                        <td>
        </form>
        <button type="submit" id="btnQuitarF" name="btnQuitarF" class="btn btn-success" onclick="return recargar()">Quitar filtro</button>

        </td>
        </tr>
        </table>
        </div>
        </form>

        <?php
        $foot = "</section><section style='position: relative; margin: auto; width: 900px;'><br><br>";
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
            $P->ingresarPaciente($pac);
            echo $foot . $P->getTabla() . "</section>";
        } elseif (isset($_REQUEST["btnModificar"])) {
            $pac->setDni($_REQUEST["dni"]);
            $pac->setNombre($_REQUEST["nombre"]);
            $pac->setTelefono($_REQUEST["telefono"]);
            $pac->setSexo($_REQUEST["sexo"]);
            $pac->setFechaNacimiento($_REQUEST["fecha_nacimiento"]);
            $pac->setCorreo($_REQUEST["correo"]);
            $P->actualizarPaciente($pac);
            echo $foot . $P->getTabla() . "</section>";
        } elseif (isset($_REQUEST["btnEliminar"])) {
            $pac->setDni($_REQUEST["dni"]);
            $pac->setNombre($_REQUEST["nombre"]);
            $pac->setTelefono($_REQUEST["telefono"]);
            $pac->setSexo($_REQUEST["sexo"]);
            $pac->setFechaNacimiento($_REQUEST["fecha_nacimiento"]);
            $pac->setCorreo($_REQUEST["correo"]);
            $P->eliminarPaciente($pac);
            echo $foot . $P->getTabla() . "</section>";
        } elseif (isset($_REQUEST["btnBuscar"])) {
            $v1 = $_REQUEST["buscar"];
            $v2 = $_REQUEST["criterio"];

        echo $P->filtrarPaciente($v1, $v2);
        } else {
            echo $foot . $P->getTabla() . "</section>";
        }
        ?>
    </section>
    <section style="position: relative; margin: auto; width: 900px;">
        <br><br>


    <script>
        function cargar(id, dni, nombre, telefono, edad, sexo, fch_nac, correo) {
            document.formulario1.codigo.value = id;
            document.formulario1.dni.value = dni;
            document.formulario1.nombre.value = nombre;
            document.formulario1.telefono.value = telefono;
            document.formulario1.edad.value = edad;
            document.formulario1.sexo.value = sexo;
            document.formulario1.fch_nac.value = fch_nac;
            document.formulario1.correo.value = correo;
            document.getElementById("btnModificar").disabled = false;
            document.getElementById("btnEliminar").disabled = false;
            document.formulario1.codigo.readOnly = true;
        }

        function validar() {
            // Obtener el formulario
            const form = document.getElementById("formulario1");

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