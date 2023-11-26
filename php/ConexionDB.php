<?php

class ConexionDB {
    private $host;
    private $usuario;
    private $clave;
    private $baseDatos;
    private $conexion;

    // Constructor
    public function __construct($host, $usuario, $clave, $baseDatos) {
        $this->host = $host;
        $this->usuario = $usuario;
        $this->clave = $clave;
        $this->baseDatos = $baseDatos;

        // Intentar establecer la conexión al momento que se instacia la clase
        $this->conectar();
    }

    // Método para establecer la conexión a la base de datos
    private function conectar() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave, $this->baseDatos);
        echo '<script>';
        echo 'console.log("Conectado")';
        echo '</script>';

        // Verificar si hay errores en la conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    // Método para cerrar la conexión a la base de datos
    public function cerrarConexion() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }

    // método para realizar una consulta
    public function hacerConsulta($consulta) {
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    public function prepare_query($sql) {
        $resultado = $this->conexion->prepare($sql);
        return $resultado;
    }

    public function error() {
        return $this->conexion->error;
    }
    
    public function getConexion() {
        return $this->conexion;
    }
    
}