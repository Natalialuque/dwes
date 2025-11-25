<?php 

class Acceso{
    
    //variables
    private $_validado;
    private $_nick;
    private $_nombre;
    private $_permisos;

    /**
     * constructor
     */
    public function __construct(){
        $this-> _validado=false;
        $this-> _nick="";
        $this->_nombre="";
        $this-> _permisos=[];
    }


    /**
     * 
     *Es una funcion donde recoges los datos de la sesion 
     * @return boolean
     */
    private function escribirASesion():bool
    {
     if (!isset($_SESSION))    
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

     return false;
    }
    
  
    /**
     * registrarUsuario(string $nick, string $nombre, array $permisos):bool. Sirve para 
     *registrar un usuario en la aplicación. Almacena los valores en las propiedades apropiadas 
     *y en la sesión para  guardar la información del usuario validado.
     *
     * @param string $nick
     * @param string $nombre
     * @param array $permisos
     * @return boolean
     */
    public function registrarUsuario(string $nick, string $nombre, array $permisos):bool{
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
     * Borrar un usuario
     *
     * @return boolean
     */
    public function quitarUsuario():bool{
         $this->_validado = false;
        if (!$this->escribirASesion())
             return false;

        return true;
    }

    /**
     * 
     * Devuelve true si hay un usuario validado y false en caso contrario. 
     *
     * @return boolean
     */
    public function hayUsuario():bool{
        if($this->_validado)
            return true;
        else 
            return false;
    }

    /**
     *  Devuelve true si tiene el permiso $numero. 
     *
     * @param [type] $numero
     * @return boolean
     */
    public function puedePermiso($numero):bool{
       if($numero>10) 
            return false;

        if($this->hayUsuario()) if($this->_permisos[$numero]==true) 
            return true;
        
        return false;
    }

    /**
     * getNick():string,
     * getNombre():string : 
     * funciones que devuelven respectivamente el Nick y el nombre del usuario registrado.
     */ 

    public function getNick():string{
        if($this->hayUsuario()) 
            return $this->_nick;
        else
            return false;
    }

    public function getNombre():string{
        if($this->hayUsuario()) 
            return $this->_nick;
        else
            return false;
    }
}
?> 