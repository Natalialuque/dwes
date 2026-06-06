<?php

class Pueblos extends CActiveRecord {
    protected function fijarNombre(): string
    {
        return 'pueblo';
    }

    protected function fijarAtributos(): array
    {
        return ["nombre","cod_tipo_elemento","descripcion_tipo","elemento","reconocido_unesco","fecha_reconocimiento"];
    }

    protected function fijarDescripciones(): array
    {
        return [
            "nombre" => "Nombre del pueblo",
            "cod_tipo_elemento"=> "Código elemento",
            "descripcion_tipo" =>"Descripcion del tipo",
            "elemento"=> "Elemento",
            "reconocido_unesco"=> "Reconocido unesco",
            "fecha_reconocimiento"=> "Fecha de reconocimiento"
        ];
    }

    protected function fijarRestricciones(): array
    {
        return [
            [
                "ATRI"=>"nombre",
                "TIPO"=>"REQUERIDO",
                "MENSAJE"=>"El nombre es obligatorio"
            ],
            [
                "ATRI"=>"nombre",
                "TIPO"=>"CADENA",
                "TAMANIO"=>25,
                "MENSAJE"=>"El nombre debe tener 25 caracteres como máximo"
            ],
            [
                "ATRI"=>"cod_tipo_elemento",
                "TIPO"=>"ENTERO",
                "MENSAJE"=>"Debe ser entero"
            ],
            [
                "ATRI"=>"cod_tipo_elemento",
                "TIPO"=>"FUNCION",
                "FUNCION"=>"validaTipo"
            ],
            [
                "ATRI"=>"descripcion_tipo",
                "TIPO"=>"CADENA",
                "TAMANIO"=>30,
                "MENSAJE"=>"El descripcion tipo debe tener 30 caracteres como máximo"
            ],
            [
                "ATRI"=>"elemento",
                "TIPO"=>"CADENA",
                "TAMANIO"=>35,
                "MENSAJE"=>"El elemento debe tener 35 caracteres como máximo"
            ],
            [
                "ATRI"=>"reconocido_unesco",
                "TIPO"=>"ENTERO",
                "MIN"=>0,
                "MAX"=>1,
                "Mensaje"=>"Reconocido unesco debe ser 0 o 1"
            ],
            [
                "ATRI"=>"fecha_reconocimiento",
                "TIPO"=>"FECHA",
                "MENSAJE"=>"Fecha mal introducida"
            ],
            [
                "ATRI"=>"fecha_reconocimiento",
                "TIPO"=>"FUNCION",
                "FUNCION"=>"validaFecha"
            ]
        ];
    }

    protected function afterCreate(): void
    {
        $this->nombre ="Pueblo";
        $this->cod_tipo_elemento = 0;
        $this->descripcion_tipo = "No indicado";
        $this->elemento = "Ele-";
        $this->reconocido_unesco = 0;
        $fecha = new DateTime("1958-07-15");
        $this->fecha_reconocimiento = $fecha->format("d/m/Y");
    }

    public function validaFecha() {
        $campo = "fecha_reconocimiento";

        // convertirlo a dd/mm/YYYY
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->$campo)) {
            $this->$campo = date("d/m/Y", strtotime($this->$campo));
        }

        // Intentar crear la fecha en formato dd/mm/YYYY
        $fecha = DateTime::createFromFormat('d/m/Y', $this->$campo);

        if ($fecha === false) {
            $this->setError($campo, "La fecha no tiene un formato válido (dd/mm/yyyy)");
        }

        if($this->reconocido_unesco==1) {
            $hoy = new DateTime("today");
            $min = date("d/m/Y",strtotime("01/01/1973"));
            
            if($fecha > $hoy || $fecha < $min) {
                $this->setError($campo, "La fecha debe ser menor que hoy y mayor a 01/01/1973");
            }
        }
        else {
            $hoy = new DateTime("today");
            if($fecha >= $hoy) {
               $this->setError($campo, "La fecha debe ser menor de hoy"); 
            }
            $fecha = new DateTime("1958-07-15");
            $this->fecha_reconocimiento = $fecha->format("d/m/Y");
        }
    }

    public function validaTipo() {
        if(Listas::listaTipoElementos(null, $this->cod_tipo_elemento) == false && $this->cod_tipo_elemento != 0) {
            $this->setError("cod_tipo_elemento", "Código de tipo elemento no existe");
        }
    }

}