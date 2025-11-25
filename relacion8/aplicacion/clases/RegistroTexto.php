<?php 

class RegistroTexto{

    //propiedades
    private string $cadena;
    private DateTime $fechaHora;


   /**
    * Al constructor le pasamos una cadena y a la fechaHora la del dia actual 
    *
    * @param string $cadena
    */
    public function __construct(string $cadena)
     {
        $this->cadena=$cadena;
        $this-> fechaHora = new DateTime(); //coge la fecha y hora actual 

     }

    /**
    * Metodo getCadena
    *
    * @return string
    */
    public function getCadena(): string {
        return $this->cadena;
    }
    /**
     * Metodo getFechaHora
     *
     * @return string
     */
  public function getFechaHora(): string {
    return $this->fechaHora->format('Y-m-d H:i:s');
}



}

?>