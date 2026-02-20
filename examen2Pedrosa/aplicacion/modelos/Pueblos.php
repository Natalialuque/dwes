<?php

class Pueblos extends CActiveRecord
{

    /**
     * Fija nombre
     *
     */
    protected function fijarNombre(): string
    {
        return 'pueblos';
    }

    /**
     * Fijar atributos
     */
    protected function fijarAtributos(): array
    {
        return ["nombre", "cod_tipo", "descripcion_tipo", "elemento", "reconocido_unesco", "fecha_reconocimiento"];
    }


    /**
     * Fijar Descripciones
     */
     protected function fijarDescripciones(): array
    {
        return [
            "nombre" => "nombre puelo",
            "cod_tipo" => "codigo del pueblo",
            "descripcion_tipo" => "decripcion del pueblo",
            "elemento" => "elemento del pueblo",
            "reconocido_unesco" => "reconocido por unesco",
            "fecha_reconocimiento" => "fecha de reconocimiento"
        ];
    }

    protected function fijarRestricciones(): array
    {
        return [
            //campos requeridos
            [
                "ATRI" => "nombre",
                "TIPO" => "REQUERIDO"
            ],
            //nombre
            [
                "ATRI" => "nombre",
                "TIPO" => "CADENA",
                "TAMANIO" => 25,
                "DEFECTO" => "pueblo",
                "MENSAJE" => "este campo debe ser obligatorio"
            ],
            //cod_tipo
            [
                "ATRI" => "cod_tipo",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarCodigoTipoElemento",
                "DEFECTO"=>0
            ],
             //descripcion_tipo
            [
                "ATRI" => "descripcion_tipo",
                "TIPO" => "FUNCION",
                "FUNCION" => "sacaApartirDeOtra",
                "DEFECTO"=> "no indicado"
            ],
            //elemento
            [
                "ATRI" => "elemento",
                "TIPO" => "CADENA",
                "TAMANIO" => 35,
                "DEFECTO" => "Ele-",
            ],
            //reconocido_unesco
            [
                "ATRI" => "reconocido_unesco",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX" =>1,
                "DEFECTO" => 0,
            ],
            //FECHA
            [
                "ATRI" => "fecha_reconocimiento",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaFecha",
                "DEFECTO" => "15/07/1958",
            ],
        ];
    }


    //FUNCION PARA VALIDAR EL CODIGO DE TIPO ELEMENTO
    public function validarCodigoTipoElemento(){
    if (Listas::ListaTiposElemento(false, $this->cod_tipo) === false)
            $this->setError("cod_tipo", "Código del tipo de elemento debe existir");
    }

    /**
     * 
     *     
     * */
     public function sacaApartirDeOtra(){
    
    }

    // }

    /**
     * VALIDAR FECHA
     *
     */
    public function validaFecha(): bool
    {
        $campo = "fecha_reconocimiento";

        // Comprobar que viene algo
        if (empty($this->$campo)) {
            $this->setError($campo, "La fecha es obligatoria");
            return false;
        }

        // Si viene en formato HTML5 (YYYY-MM-DD), convertirlo a dd/mm/YYYY
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->$campo)) {
            $this->$campo = date("d/m/Y", strtotime($this->$campo));
        }

        // Intentar crear la fecha en formato dd/mm/YYYY
        $fecha = DateTime::createFromFormat('d/m/Y', $this->$campo);

        if ($fecha === false) {
            $this->setError($campo, "La fecha no tiene un formato válido (dd/mm/yyyy)");
            return false;
        }
    return true;
        
    }


    /**
     * after create
     */
    public function afterCreate(): void
    {
        $this->nombre = "pueblo";
        $this->cod_tipo = 0;
        $this->descripcion_tipo = "no indicado";
        $this->elemento ="Ele";
        $this -> reconocido_unesco = 0;
        $this->fecha = "15/07/1958";
    }


}