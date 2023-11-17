<?php
class Medico extends Persona {
//ATRIBUTOS
    private $con;
    private $idMedico;
    private $consultorio;
    private $horario;
    
    private $fecha;
    private $hora;
    private $paciente;
    private $motivo;
    private $diagnostico;
    private $tratamiento;
//CONSTRUCTOR
    public function __construct() {
       
    }
//GETTER Y SETTER
    public function getIdMedico() {
        return $this->idMedico;
    }

    public function getConsultorio() {
        return $this->consultorio;
    }

    public function getHorario() {
        return $this->horario;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function getMotivo() {
        return $this->motivo;
    }

    public function getDiagnostico() {
        return $this->diagnostico;
    }

    public function getTratamiento() {
        return $this->tratamiento;
    }
    public function setIdMedico($idMedico): void {
        $this->idMedico = $idMedico;
    }

    public function setConsultorio($consultorio): void {
        $this->consultorio = $consultorio;
    }

    public function setHorario($horario): void {
        $this->horario = $horario;
    }

    public function setFecha($fecha): void {
        $this->fecha = $fecha;
    }

    public function setHora($hora): void {
        $this->hora = $hora;
    }

    public function setPaciente($paciente): void {
        $this->paciente = $paciente;
    }

    public function setMotivo($motivo): void {
        $this->motivo = $motivo;
    }

    public function setDiagnostico($diagnostico): void {
        $this->diagnostico = $diagnostico;
    }

    public function setTratamiento($tratamiento): void {
        $this->tratamiento = $tratamiento;
    }
//METODOS PROPIOS
        public function agregarmedico(){
        global $conn;

        // Preparar la consulta SQL
        $sql = "INSERT INTO medico (primerNombre, segundoNombre, primerApellido, SegundoApellido, dni, telefono, sexo, fechaDeNacimiento, Edad, direccion, correoElectronico, consultorio, horario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Preparar la declaración
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt) {
            // Enlazar parámetros
            $stmt->bind_param("sssssssssssss", $this->primerNombre, $this->segundoNombre, $this->primerApellido, $this->SegundoApellido, $this->dni, $this->telefono, $this->sexo, $this->fechaDeNacimiento, $this->Edad, $this->direccion, $this->correoElectronico, $this->consultorio, $this->horario);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false; // Hubo un error en la preparación de la consulta
        }
    
    }
    
    public function actualizarMedico($dni) {
        global $conn;

        // Verificar si el médico existe antes de actualizar
        $sql_verificacion = "SELECT idMedico FROM medico WHERE dni=?";
        $stmt_verificacion = $conn->prepare($sql_verificacion);
        $stmt_verificacion->bind_param("s", $dni);
        $stmt_verificacion->execute();
        $stmt_verificacion->store_result();

        if ($stmt_verificacion->num_rows > 0) {
            // El médico existe, proceder con la actualización

            // Preparar la consulta SQL para actualizar
            $sql_actualizacion = "UPDATE medico SET primerNombre=?, segundoNombre=?, primerApellido=?, SegundoApellido=?, dni=?, telefono=?, sexo=?, fechaDeNacimiento=?, Edad=?, direccion=?, correoElectronico=?, consultorio=?, horario=? WHERE dni=?";
            $stmt_actualizacion = $conn->prepare($sql_actualizacion);

            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt_actualizacion) {
                // Asignar nuevos valores a las propiedades del médico
                $this->dni = $dni;

                // Enlazar parámetros
                $stmt_actualizacion->bind_param("ssssssssssssss", $this->primerNombre, $this->segundoNombre, $this->primerApellido, $this->SegundoApellido, $this->dni, $this->telefono, $this->sexo, $this->fechaDeNacimiento, $this->Edad, $this->direccion, $this->correoElectronico, $this->consultorio, $this->horario, $dni);

                // Ejecutar la consulta
                if ($stmt_actualizacion->execute()) {
                    return "El médico se ha actualizado correctamente.";
                } else {
                    return "Hubo un problema al actualizar el médico.";
                }
            } else {
                return "Hubo un error en la preparación de la consulta.";
            }
        } else {
            return "El médico con DNI $dni no existe.";
        }
    }
    
    public function verMedicos() {
        $sql = "SELECT * FROM medico WHERE dni=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $dni);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El médico existe, obtener y devolver la información
            $medicoInfo = $result->fetch_assoc();
            return $medicoInfo; // Aquí podrías hacer lo que desees con esta información
        } else {
            return "El médico con DNI $dni no existe.";
        }
    }
    public function eliminarMedicos($dni) {
        global $conn;

        // Verificar si el médico existe antes de eliminarlo
        $sql_verificacion = "SELECT idMedico FROM medico WHERE dni=?";
        $stmt_verificacion = $conn->prepare($sql_verificacion);
        $stmt_verificacion->bind_param("s", $dni);
        $stmt_verificacion->execute();
        $stmt_verificacion->store_result();

        if ($stmt_verificacion->num_rows > 0) {
            // El médico existe, proceder con la eliminación

            // Preparar la consulta SQL para eliminar
            $sql_eliminacion = "DELETE FROM medico WHERE dni=?";
            $stmt_eliminacion = $conn->prepare($sql_eliminacion);

            // Verificar si la preparación de la consulta fue exitosa
            if ($stmt_eliminacion) {
                // Enlazar parámetros
                $stmt_eliminacion->bind_param("s", $dni);

                // Ejecutar la consulta
                if ($stmt_eliminacion->execute()) {
                    return "El médico se ha eliminado correctamente.";
                } else {
                    return "Hubo un problema al eliminar el médico.";
                }
            } else {
                return "Hubo un error en la preparación de la consulta.";
            }
        } else {
            return "El médico con DNI $dni no existe.";
        }
    }
}

