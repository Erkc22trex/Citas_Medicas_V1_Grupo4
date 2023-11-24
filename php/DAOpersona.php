<?php
//HOLA
    include 'informacion.php'; /* lo primero que debemos hacer es garantizar el acceso de ésta clase a la BD con la tabla Persona */
    include 'Persona.php';     //incluir también la clase que responde a la tabla para la que hacemos el DAO
       
    class DAOPersona{
        private $con; // para la conexión a la base de datos
        
        public function __construct() {}
        
        //Método para conectarse a la base de datos
        public function conectar() {
            $this->con  =   new mysqli(SERVIDOR, USUARIO, CLAVES, BD) or die ("Error al conectar");            
        }
        
        //método para cerrar la conexión a la base de datos
        public function desconectar() { $this->con->close(); }
        
        //obtener todas las tuplas de la tabla para la que creamos el DAO
        public function getTabla() {
            $sql    =   "select * from persona"; //consulta SQL para obtener las tuplas
            $this->conectar();                      //conectarse a la BD
            $res = $this->con->query($sql);         //almaceno en res el resultado de la consulta           
            /*mostrar la tabla, para el css usaremos bootstrap. El bootstrap se incluirá en los objetos de negocio, "las vistas"
            //creamos un string con el HTML que mostraremos en el lado del cliente
            //res ya tiene los datos de la tabla*/
            $tabla = "<table class = 'table table-dark'>"
                    . "<thead class = 'thead thead-light'>";
            $tabla .= "<tr><th>ID</th><th>Primer Nombre</th><th>Segundo Nombre</th>"
                    ."<th>Primer Apellido</th><th>Segundo Apellido</th><th>DNI</th>"
                    ."<th>Telefono</th><th>Sexo</th><th>Fecha De Nacimiento</th>"
                    ."<th>Edad</th><th>Direccion</th><th>Correo Electronico</th><th>Accion</th>"
                    ."</tr></thead><tbody>";
            //cuerpo de la tabla              
            while($tupla = mysqli_fetch_assoc($res)){
                $tabla .= "<tr>"
//                    ."<td>".$tupla["idPersona"]."</td>"
                    ."<td>".$tupla["primerNombre"]."</td>"
                    ."<td>".$tupla["segundoNombre"]."</td>"
                    ."<td>".$tupla["primerApellido"]."</td>"
                    ."<td>".$tupla["segundoApellido"]."</td>"
                    ."<td>".$tupla["dni"]."</td>"
                    ."<td>".$tupla["telefono"]."</td>"
                    ."<td>".$tupla["sexo"]."</td>"
                    ."<td>".$tupla["fechaDeNacimiento"]."</td>"
                    ."<td>".$tupla["edad"]."</td>"
                    ."<td>".$tupla["direccion"]."</td>"
                    ."<td>".$tupla["correoElectronico"]."</td>"
                    ."<td><a href=\"javascript:cargar('".$tupla["primerNombre"]
                    ."','".$tupla["segundoNombre"]."','".$tupla["primerApellido"]."','".$tupla["segundoApellido"]
                    ."','".$tupla["dni"]."','".$tupla["telefono"]."','".$tupla["sexo"]
                    ."','".$tupla["fechaDeNacimiento"]."','".$tupla["edad"]."','".$tupla["direccion"]
                    ."','".$tupla["correoElectronico"]
                    ."')\">Seleccionar</a></td>" 
                    ."</tr>";               
            }
            $tabla .="</tbody></table>";
            $res->close();
            $this->desconectar();                   //cierro la conexión a la BD
            return $tabla;
        }
        
        public function existe($objeto) {
            $p   = new Persona();
            $p   = $objeto;
            $sql = "select * from persona where dni = ".$p->getDni();
            $this->conectar();
            $filas = $this->con->query($sql);
            if($filas->num_rows){ return true;} else { return false;}
            $filas->close();
            $this->desconectar();
        }
        
    public function insertar($objeto) {                     
    $p = $objeto;
    
    if ($this->existe($p)) {  
        echo "<script>swal({title:'Error',text:'Ya existe una persona con ese DNI.', type: 'error'});</script>";
    } else {   
        $sql = "INSERT INTO persona (primerNombre, segundoNombre, primerApellido, segundoApellido, dni, telefono, sexo, fechaDeNacimiento, edad, direccion, correoElectronico) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $this->conectar();
        $stmt = $this->con->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("ssssssssiss", 
            $primerNombre,
            $segundoNombre,
            $primerApellido,
            $SegundoApellido,
            $dni,
            $telefono,
            $sexo,
            $fechaDeNacimiento,
            $edad,
            $direccion,
            $correoElectronico
            );

            $primerNombre = $p->getPrimerNombre();
            $segundoNombre = $p->getSegundoNombre();
            $primerApellido = $p->getPrimerApellido();
            $SegundoApellido = $p->getSegundoApellido();
            $dni = $p->getDni();
            $telefono = $p->getTelefono();
            $sexo = $p->getSexo();
            $fechaDeNacimiento = $p->getFechaDeNacimiento();
            $edad = $p->getEdad();
            $direccion = $p->getDireccion();
            $correoElectronico = $p->getCorreoElectronico();

            if ($stmt->execute()) {
                echo "<script>swal({title:'Inserción exitosa',text:'Se ha agregado con éxito a la base de datos.', icon: 'success', type: 'success'});</script>";
            } else {
                echo "<script>swal({title:'Error',text:'No se ha podido agregar a la base de datos.', icon: 'error', type: 'error'});</script>";
            }
            
            $stmt->close();
        }
        
        $this->desconectar();  
    }             
}
        
        public function eliminar($objeto) {
            $p   = new Persona();
            $p   = $objeto;
            if($this->existe($p)){                 
                $sql = "delete from persona where dni = ".$p->getDni(); 
                $this->conectar();
                if($this->con->query($sql)){
                    //mensaje de éxito con sweet alert                             
                    echo"<script>swal({title:'Borrado exitoso',text:'Se ha eliminado con éxito a la base de datos.', type: 'success'});</script>";
                }else{  
                    //mensaje de error con sweet alert   
                    echo"<script>swal({title:'Error',text:'No se ha podido eliminar a la base de datos.', type: 'error'});</script>";
                }
                $this->desconectar();                  
            }else{                          
                //mensaje de error con sweet alert                   
                echo"<script>swal({title:'Error',text:' No existe una persona con ese código.', type: 'error'});</script>";
            }               
        }
    
        public function actualizar($objeto){
        $p   = new Persona();
            $p   = $objeto;
            if($this->existe($p)){                 
                $sql = "UPDATE persona SET primerNombre = '".$p->getPrimerNombre()."', segundoNombre = '".$p->getSegundoNombre()
                        ."',primerApellido = '".$p->getPrimerApellido()."', segundoApellido = '".$p->getSegundoApellido()
                        ."', telefono = '".$p->getTelefono()."', sexo = '".$p->getSexo()."', fechaDeNacimiento = '".$p->getFechaDeNacimiento()
                        ."', edad = '".$p->getEdad()."', Direccion = '".$p->getDireccion()."', correoElectronico = '".$p->getCorreoElectronico()
                        ."' WHERE dni = ".$p->getDni(); 
                $this->conectar();
                if($this->con->query($sql)){
                    //mensaje de éxito con sweet alert                             
                    echo"<script>swal({title:'Actualización exitosa',text:'Datos actualizados correctamente.', type: 'success'});</script>";
                }else{  
                    //mensaje de error con sweet alert   
                    echo"<script>swal({title:'Error',text:'No se ha podido actualizar la base de datos.', type: 'error'});</script>";
                }
                $this->desconectar();                  
            }else{                          
                //mensaje de error con sweet alert                   
                echo"<script>swal({title:'Error',text:' No existe una persona con ese código.', type: 'error'});</script>";
            }               
        }
        
        public function filtrar($valor, $criterio) {
    // Cambiamos la consulta para buscar solo por DNI
    $sql = "SELECT * FROM persona WHERE dni = '$valor'";
    
    $this->conectar();
    $res = $this->con->query($sql);

    // Resto del código para generar la tabla, manteniendo los elementos deseados en el while
    $tabla = "<table class='table table-dark'>"
            . "<thead class='thead thead-light'>"
            . "<tr><th>Primer Nombre</th><th>Segundo Nombre</th>"
            . "<th>Primer Apellido</th><th>Segundo Apellido</th><th>DNI</th>"
            . "<th>Telefono</th><th>Sexo</th><th>Fecha De Nacimiento</th>"
            . "<th>Edad</th><th>Direccion</th><th>Correo Electronico</th><th>Accion</th>"
            . "</tr></thead><tbody>";

    while($tupla = mysqli_fetch_assoc($res)) {
        // Mantenemos solo las columnas necesarias (puedes agregar o quitar según lo necesites)
        $tabla .= "<tr>"
                ."<td>".$tupla["primerNombre"]."</td>"
                ."<td>".$tupla["segundoNombre"]."</td>"
                ."<td>".$tupla["primerApellido"]."</td>"
                ."<td>".$tupla["segundoApellido"]."</td>"
                ."<td>".$tupla["dni"]."</td>"
                ."<td>".$tupla["telefono"]."</td>"
                ."<td>".$tupla["sexo"]."</td>"
                ."<td>".$tupla["fechaDeNacimiento"]."</td>"
                ."<td>".$tupla["edad"]."</td>"
                ."<td>".$tupla["direccion"]."</td>"
                ."<td>".$tupla["correoElectronico"]."</td>"
                ."<td><a href=\"javascript:cargar('".$tupla["primerNombre"]
                ."','".$tupla["segundoNombre"]."','".$tupla["primerApellido"]."','".$tupla["segundoApellido"]
                ."','".$tupla["dni"]."','".$tupla["telefono"]."','".$tupla["sexo"]
                ."','".$tupla["fechaDeNacimiento"]."','".$tupla["edad"]."','".$tupla["direccion"]
                ."','".$tupla["correoElectronico"]
                ."')\">Seleccionar</a></td>" 
                ."</tr>";               
    }

    $tabla .="</tbody></table>";
    $res->close();
    $this->desconectar();
    return $tabla;
}

    } 
    