 <?php
include_once 'Persona.php'; // Incluye la clase Persona

class DAOmedico {
    public function insertar() {
        // Aquí puedes utilizar los setters de Persona para establecer los datos compartidos
        $persona = new Persona();
        $persona->setPrimerNombre("Nombre");
        $persona->setSegundoNombre("SegundoNombre");
        // ... Establecer otros atributos compartidos con Persona

        // Luego establece los atributos específicos de Medico
        $persona->setEspecialidad($medico->getEspecialidad());
        $persona->setConsultorio($medico->getConsultorio());
        // ... Establecer otros atributos específicos de Medico

        // Aquí llamas al método insertar de Persona
        $resultadoInsertarPersona = $persona->insertar(); // Suponiendo que este método existe en la clase Persona
        // Realizar otras operaciones si es necesario y retornar un resultado
        return $resultadoInsertarPersona;
    }

    // Resto de los métodos CRUD y métodos específicos de Medico si es necesario
    // ...
}
