<?php
    include 'DAOpersona.php';
    $P = new DAOPersona();
    $per = new Persona();
?>
<head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        <script src="import/jquery/jquery.js" type="text/javascript"></script>
        <script>
            function cargar(primerNombre,segundoNombre,primerApellido,segundoApellido,DNI,telefono,sexo,fechaDeNacimiento,edad,direccion,correoElectronico){
                document.formulario1.primerNombre.value=primerNombre;
                document.formulario1.segundoNombre.value=segundoNombre;
                document.formulario1.primerApellido.value=primerApellido;
                document.formulario1.segundoApellido.value=segundoApellido;
                document.formulario1.dni.value=DNI;
                document.formulario1.telefono.value=telefono;
                document.formulario1.sexo.value=sexo;
                document.formulario1.fechaDeNacimiento.value=fechaDeNacimiento;
                document.formulario1.edad.value=edad;
                document.formulario1.direccion.value=direccion;
                document.formulario1.correoElectronico.value=correoElectronico;
                document.getElementById("btnModificar").disabled = false;
                document.getElementById("btnEliminar").disabled = false;     
                document.formulario1.dni.readOnly = true;
            }
        </script>
            
    </head>
    <body>
        <section>
             <h2 style="position: relative; margin: auto; width: 500px;">Formulario de personas</h2>

            <form action="vistaPersona.php" method="post" name = "formulario1" id = "formulario1" onsubmit="return validar()" style="position: relative; margin: auto; width: 500px;">
                <div class="mb-3">
                    <label for="primerNombre">Primer Nombre</label>
                    <input type="text" class="form-control" id="primerNombre" name="primerNombre" maxlength="70">
                
                    <label for="segundoNombre">Segundo Nombre</label>
                    <input type="text" class="form-control" id="segundoNombre" name="segundoNombre" maxlength="70">
                
                    <label for="primerApellido">Primer Apellido</label>
                    <input type="text" class="form-control" id="primerApellido" name="primerApellido" maxlength="70">
                    
                    <label for="segundoApellido">Segundo Apellido</label>
                    <input type="text" class="form-control" id="segundoApellido" name="segundoApellido" maxlength="70">
                    
                    <label for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" maxlength="15">
               
                    <label for="telefono">Telefono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" maxlength="15">
                
                    <label for="sexo">Sexo</label>
                    <input type="text" class="form-control" id="sexo" name="sexo" maxlength="100">
                    
                    <label for="fechaDeNacimiento" class="form-label">Fecha de Nacimiento:</label>
                    <input type="text" class="form-control" id="fechaDeNacimiento" name="fechaDeNacimiento" placeholder="AAAA-MM-DD">
                    
                    <label for="edad" class="form-label">Edad:</label>
                    <input type="number" class="form-control" id="edad" name="edad" required>
                    
                    <label for="direccion" class="form-label">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                    
                    <label for="correoElectronico" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required>
                  
                </div>
                <button type="submit" id = "btnAgregar" name = "btnAgregar" class="btn btn-primary">Agregar</button>
                <button type="submit" id = "btnModificar" name = "btnModificar" class="btn btn-danger" disabled>modificar</button>
                <button type="submit" id = "btnEliminar" name = "btnEliminar" class="btn btn-dark" disabled>Eliminar</button>     
            </form>
             <br>
             <!-- formulario para búsquedas --> 
              <form action="vistaPersona.php" method="post" name = "formulario2" id = "formulario2" onsubmit="" style="position: relative; margin: auto; width: 500px;">
                <div class="mb-1">
                    <label for="busqueda">Buscar: </label>
                    <input type="text" class="form-control" id="buscar" name="buscar" >                
                    <label for="criterio">Buscar por: </label>
                    <table>
                        <tr><td><select class="form-select" id="criterio" name="criterio" style="width: 300px;">
<!--                              <option value="codigo">Primer Nombre</option>
                              <option value="nombre">Segundo Nombre</option>
                              <option value="codigo">Primer Apellido</option>
                              <option value="nombre">Segundo Apellido</option>-->
                              <option value="dni">DNI</option>
<!--                              <option value="id">Telefono</option>
                              <option value="id"></option>
                              <option value="id">DNI</option>
                              <option value="id">DNI</option>
                              <option value="nombreUsuario">Nombre de usuario</option>-->
                            </select>
                          </td> <td>
                              <button type="submit" id="btnBuscar" name="btnBuscar" class="btn btn-secondary" onclick="return validar2()">Buscar</button> </td><td></form>
                            <button type="submit" id="btnQuitarF" name="btnQuitarF" class="btn btn-success" onclick="return recargar()">Quitar filtro</button>
                          </td></tr></table> 
               </div>
            </form>
             
            <script> 
                
                function validar() {
                    // Obtener el formulario
                    const form = document.getElementById("formulario1");

                    // Comprobar que todos los campos estén rellenos
                    const inputs = form.querySelectorAll("input");
                    for (const input of inputs) {
                        if (input.value === "") {
                            // Mostrar un sweet alert
                            Swal.fire({title: "Error",text: "El campo " + input.dni + " es obligatorio",icon: "error", buttons: ["Aceptar"]});
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
                            Swal.fire({title: "Error",text: "El campo " + input.dni + " es obligatorio",icon: "error",buttons: ["Aceptar"]});
                            return false;
                        }
                    }
                    return true;
                }
                
                function recargar(){
                    location.reload();
                }
            </script>       
            <?php
                $foot = "</section><section style='position: relative; margin: auto; width: 900px;'><br><br>";
                if(isset($_REQUEST["btnAgregar"])){
                    $per->setPrimerNombre($_REQUEST["primerNombre"]);
                    $per->setSegundoNombre($_REQUEST["segundoNombre"]);
                    $per->setPrimerApellido($_REQUEST["primerApellido"]);
                    $per->setSegundoApellido($_REQUEST["segundoApellido"]);
                    $per->setDni($_REQUEST["dni"]);
                    $per->setTelefono($_REQUEST["telefono"]);
                    $per->setSexo($_REQUEST["sexo"]);
                    $per->setFechaDeNacimiento($_REQUEST["fechaDeNacimiento"]);
                    $per->setEdad($_REQUEST["edad"]);
                    $per->setDireccion($_REQUEST["direccion"]);
                    $per->setCorreoElectronico($_REQUEST["correoElectronico"]);
                    
                    $P->insertar($per);
                    
//                    echo $foot.$P->getTabla()."</section>"; 
                }elseif(isset($_REQUEST["btnModificar"])){
                    $per->setPrimerNombre($_REQUEST["primerNombre"]);
                    $per->setSegundoNombre($_REQUEST['segundoNombre']);
                    $per->setPrimerApellido($_REQUEST['primerApellido']);
                    $per->setSegundoApellido($_REQUEST['segundoApellido']);
                    $per->setDni($_REQUEST['dni']);
                    $per->setTelefono($_REQUEST['telefono']);
                    $per->setSexo($_REQUEST['sexo']);
                    $per->setFechaDeNacimiento($_REQUEST['fechaDeNacimiento']);
                    $per->setEdad($_REQUEST['edad']);
                    $per->setDireccion($_REQUEST['direccion']);
                    $per->setCorreoElectronico($_REQUEST['correoElectronico']);
                    $P->actualizar($per);
//                    echo $foot.$P->getTabla()."</section>";    
                    
                }elseif(isset($_REQUEST["btnEliminar"])){
                    $per->setPrimerNombre($_REQUEST["primerNombre"]);
                    $per->setSegundoNombre($_REQUEST['segundoNombre']);
                    $per->setPrimerApellido($_REQUEST['primerApellido']);
                    $per->setSegundoApellido($_REQUEST['segundoApellido']);
                    $per->setDni($_REQUEST['dni']);
                    $per->setTelefono($_REQUEST['telefono']);
                    $per->setSexo($_REQUEST['sexo']);
                    $per->setFechaDeNacimiento($_REQUEST['fechaDeNacimiento']);
                    $per->setEdad($_REQUEST['edad']);
                    $per->setDireccion($_REQUEST['direccion']);
                    $per->setCorreoElectronico($_REQUEST['correoElectronico']);                    
                    $P->eliminar($per);
//                    echo $foot.$P->getTabla()."</section>"; 
                    
                }elseif(isset($_REQUEST["btnBuscar"])){
                    $v1 = $_REQUEST["buscar"];
                    $v2 = $_REQUEST["criterio"];
                    ?>
                    </section><section style="position: relative; margin: auto; width: 1900px;">
                     <br><br>
                <?php
                    echo $P->filtrar($v1,$v2);
                }else{"</section>";  } ?>
    </body>
</html>