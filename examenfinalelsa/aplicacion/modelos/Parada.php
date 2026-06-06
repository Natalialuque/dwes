<?php
class Parada extends CActiveRecord

{
    private string $_prefijo = "PAR-";


    /**
     * Redefinición del método fijarNombre
     *
     * @return string
     */
    protected function fijarNombre(): string
    {
        return "parada";
    }
    /**
     * Redefinicón del método fijarAtributos
     *
     * @return Array
     */
    protected function fijarAtributos(): array
    {
        return array(
            "cod_trayecto",
            "nombreTrayecto",
            "estacion",
            "poblacion",
            "es_origen",
        );
    }
    /**
     * Redefinicón del método fijarDescripciones
     * @return Array
     */
    protected function fijarDescripciones(): array
    {
        return array(
            "cod_trayecto" => $this->_prefijo . "Trayecto",
            "nombreTrayecto" => $this->_prefijo . "Nombre del Trayecto",
            "estacion" => $this->_prefijo . "Estación",
            "poblacion" => $this->_prefijo . "Población",
            "es_origen" => $this->_prefijo . "Es Origen",
        );
    }
    /**
     * Redefinicón del método fijarRestricciones
     *
     * @return Array
     */
    protected function fijarRestricciones(): array
    {
        return array(
            [
                "ATRI" => "cod_trayecto,estacion",
                "TIPO" => "REQUERIDO"
            ],

            [
                "ATRI" => "cod_trayecto",
                "TIPO" => "ENTERO",
                "MENSAJE" => "El código de partida debe ser un número"
            ],

            [
                "ATRI" => "cod_trayecto",
                "TIPO" => "RANGO",
                "RANGO" => array_keys(Listas::listaTrayectos(true)),
                "MENSAJE" => "El código de trayecto debe estar entre los válidos"
            ],


            [
                "ATRI" => "nombreTrayecto",
                "TIPO" => "CADENA",
                "DEFECTO" => $this->rellenaNombre(),
            ],

            [
                "ATRI" => "nombreTrayecto",
                "TIPO" => "FUNCION",
                "FUNCION" => $this->rellenaNombre(),
            ],

            [
                "ATRI" => "estacion",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "DEFECTO" => "-",
                "MENSAJE" => "La estación no puede tener más de 30 carct."

            ],
            [
                "ATRI" => "poblacion",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "DEFECTO" => "Antequera",
                "MENSAJE" => "La estación no puede tener más de 30 carct."

            ],
            [
                "ATRI" => "poblacion",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaPoblacion"

            ],
            [
                "ATRI" => "es_origen",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX" => 1,
                "DEFECTO" => $this->esOrigen(),

            ],
            [
                "ATRI" => "es_origen",
                "TIPO" => "FUNCTION",
                "FUNCTION" => "esOrigen"
            ],

        );
    }


    protected function afterCreate(): void
    {
        if($this->nombreTrayecto == null || $this->nombreTrayecto == ""){
            $this->nombreTrayecto = $this->rellenaNombre();
        }
        $this->es_origen = $this->esOrigen();
        $this->poblacion ="Antequera";
    }

    protected function afterBuscar(): void
    {
        if($this->nombreTrayecto == null || $this->nombreTrayecto == ""){
            $this->nombreTrayecto = $this->rellenaNombre();
        }
        $this->es_origen = $this->esOrigen();
        $this->poblacion ="Antequera";
    }




    public function validaPoblacion(): bool
    {
        if ($this->poblacion == "Archidona") {
            return false;
        }
        return true;
    }


    public function rellenaNombre()
    {
        if ($this->cod_trayecto != "") {
            $trayectos = Listas::listaTrayectos(false);
            foreach ($trayectos as $key => $value) {
                if ($this->cod_trayecto == $key) {
                    return $value;
                }
            }
        }
        return "";
    }

    public function esOrigen()
    {
        $ciudades = explode("-", $this->nombreTrayecto);

        if (mb_strtolower($this->poblacion) == mb_strtolower($ciudades[0])) {
            return 1;
        }
        return 0;
    }

    public function getTodosAtributos(){
        $atributos = [];
        $atributos["nombreTrayecto"]= $this->nombreTrayecto;
        $atributos["estacion"]= $this->estacion;
        $atributos["poblacion"]= $this->poblacion;
        $atributos["es_origen"]= $this->es_origen;
        return $atributos;

    }
}
