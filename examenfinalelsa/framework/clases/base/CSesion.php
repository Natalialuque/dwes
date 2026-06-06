<?php

class CSesion {
    // Constructor: inicia la sesión cuando se crea un objeto de esta clase
    public function __construct() {
        // Iniciar la sesión si no está iniciada ya
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    

    /**
     * Función para crear la sesión
     *
     * @return void
     */
    public function crearSesion()
    {
        if (!$this->haySesion())
            session_start();
    }

    /**
     * Función que comprueba si existe una sesión
     *
     * @return boolean --> True si existe una sesión actualmente, 
     * false en caso contrario.
     */
    public function haySesion() :bool
    {
        if(isset($_SESSION))
            return true;
        
        return false;
    }

    /**
     * Función que se encarga de destruir la sesión actual.
     *
     * @return void
     */
    public function destruirSesion()
    {
        if ($this->haySesion())
            session_destroy();
    }
}