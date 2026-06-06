<?php 
class CAcceso {
    
    // Variables de instancia
    private $_validado;
    private $_nick;
    private $_nombre;
    private $_permisos;
    private CSesion $_sesion;
    
    
    // Constructor
    public function __construct() {
        
        $this->_validado=false;
        $this->_nick="";
        $this->_nombre="";
        $this->_permisos=[];
        $this->_sesion = new CSesion();
        $this->_sesion->crearSesion();
        $this->recogerDeSesion();
        
    }
    
    /**
     * Funcion privada para guardar la información en la sesión
     *
     * @return boolean Devuelve true si se ha podido hacer. False en cualquier otro caso
     */
    private function escribirASesion():bool
    {
     if (!isset($this->_sesion))    
         return false;
     
     if ($this->_validado)
     {
         $_SESSION["acceso"]["validado"]=true;
         $_SESSION["acceso"]["nick"]=$this->_nick;
         $_SESSION["acceso"]["nombre"]=$this->_nombre;
         $_SESSION["acceso"]["permisos"]=$this->_permisos;
         
     }
     else 
     {
         $_SESSION["acceso"]["validado"]=false;
     }
     return $_SESSION["acceso"]["validado"];
    }
    
    /**
     * Función privada que recoje la información de la sesión
     *
     * @return boolean Devuelve true si se ha podido recoger
     */
    private function recogerDeSesion():bool
    {
       if (!isset($this->_sesion) ||
           !isset($_SESSION["acceso"]) ||
           !isset($_SESSION["acceso"]["validado"]) ||
           $_SESSION["acceso"]["validado"]==false)
       {
           $this->_validado=false;
       }
       else 
       {
           $this->_validado=true;
           $this->_nick=$_SESSION["acceso"]["nick"];
           $this->_nombre=$_SESSION["acceso"]["nombre"];
           $this->_permisos=$_SESSION["acceso"]["permisos"];
           
       }

       return true;
        
    }

     /**
     * Registra un usuario
     * 
     *
     * @param string 
     * @param string 
     * @param array 
     * @return boolean 
     */
    public function registrarUsuario(string $nick, string $nombre, array $permisos):bool
     {
        if ($nick == "")
            $this->_validado = false;
        else
            $this->_validado = true;
        $this->_nick = $nick;
        $this->_nombre = $nombre;
        $this->_permisos = $permisos;
        
        if (!$this->escribirASesion())
            return false;

        return true;
    }
    
    
   /**
     * Elimina la información de registro de un usuario
     *
     * @return boolean 
     */
    public function quitarRegistroUsuario():bool {
        $this->_validado = false;
        if (!$this->escribirASesion())
             return false;
        return true;
    }
    
    /**
     * Función que devuelve si hay o no un usuario registrado
     *
     * @return boolean Devuelve true si hay usuario registrado. False en caso contrario
     */
    public function hayUsuario():bool {
        return $this->_validado;
    }
    
    
    /**
     * Función que devuelve si el usuario registrado tiene o no el permiso indicado
     *
     * @param integer 
     * @return bool 
     */
    public function puedePermiso(int $numero):bool 
    {
        if(!($this -> hayUsuario()))
            return false;

        if(isset($this -> _permisos[$numero]) && $this -> _permisos[$numero] == true){
            return true;
        }
        else {
            return false;
        }
    }
    
    
    /*
     * Métodos get
     */

     /**
      * Devuelve el nick del usuario indicado o false si no hay usuario
      *
      * @return string|false
      */
    public function getNick():string|false 
    { 
       if(!($this -> hayUsuario()))
        return false;
        
        return $this -> _nick;
    }
  
    /**
     * Devuelve el nombre del usuario registrado o false si no hay usuario
     *
     * @return string|false
     */
    public function getNombre():string|false 
    { 
        if (!$this->hayUsuario())
            return false;
        
        return $this->_nombre; 
    }    
    
}
