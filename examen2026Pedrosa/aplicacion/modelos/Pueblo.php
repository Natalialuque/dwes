<?php
class Pueblo extends CActiveRecord{

    //fijamos nombre 
     protected function fijarNombre(): string
    {
        return 'pueblo';
    }

    //fijamos atributos 
     protected function fijarAtributos(): array
    {
        return ["nombre", "cod_tipo_elemento", "descripcion_tipo", "elemento", "reconocido_unesco", "fecha_reconocimiento"];
    }

    //fijamos las descripciones 
     protected function fijarDescripciones(): array
    {
        return [
            "nombre" => "Pueb-nombre",
            "cod_tipo_elemento" => "Pueb-cod_tipo_elemento",
            "descripcion_tipo" => "Pueb-descripcion_tipo",
            "elemento" => "Pueb-elemento ",
            "reconocido_unesco" => "Pueb-reconocido_unesco",
            "fecha_reconocimiento" => "Pueb-fecha_reconocimiento"
        ];
    }

    protected function fijarRestricciones(): array
    {
        return [
            [
                //primero metemos los que son obligatorios
                "ATRI" => "nombre",
                "TIPO" => "REQUERIDO",
                "MENSAJE"=> "nombre obligatorio"
            ],
            [
                //nombre, cadena 25, defecto pueblo
                "ATRI" => "nombre",
                "TIPO" => "CADENA",
                "TAMANIO"=>25,
                "MENSAJE"=> "nombre debe tener 25 caracteres"
            ],
            [
                //entero, debe estar en el rango de codigos de lista TIpos Elemento 
                "ATRI" => "cod_tipo_elemento",
                "TIPO" => "ENTERO",
                "MENSAJE" => "debe ser entero"
            ],
            [
                //y ahora le pasamos la funcion  
                "ATRI" => "cod_tipo_elemento",
                "TIPO" => "FUNCION",
                "MENSAJE" => "validaTipo"
            ],
            [
                //descripcion tipo, cadena 30, valor obtenido de cod_tipo
                "ATRI" => "descripcion_tipo",
                "TIPO" => "CADENA",
                "TAMANIO"=> 30,
                "MENSAJE"=> "cadena de 30 caracteres"
            ],
            [
                //ahora le pasamos la funcion de obtenido de cod_tipo
                "ATRI" => "descripcion_tipo",
                "TIPO" => "FUNCION",
                "FUNCION" => "obtenidoCodTipo"
            ],
            [
                //Eelemento cadena de 35
                "ATRI" => "elemento",
                "TIPO" => "CADENA",
                "TAMANIO"=> 35,
                "MENSAJE"=> "cadena de 35 caracteres"
            ],
            [
                //reconocido por la unesco, entero, valor 0-1, dependiendo valor se sabe si tiene reco
                "ATRI" => "reconocido_unesco",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX"=>1,
                "MENSAJE"=>"Reconocido por la unesco debe ser 0 o 1"
            ],
            [
                //fecha de reconocimiento formato fecha mediante funcion error 
                "ATRI" => "fecha_reconocimiento",
                "TIPO" => "FECHA",
                "MENSAJE" => "fecha mal introducida",
            ],
            [
                //metemos la funcion 
                "ATRI" => "fecha_reconocimiento",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaFecha"
            ]
        ];
    }

    //vamos ahora con los valores por defecto 
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

    /**
     * ahora aqui vamos con las funciones para realizar validaciones 
     */
    //de cod_tipo_elemento para ver cual toca 
    function validaTipo(){ 
        if(Listas::listaTipoElemento($this->cod_tipo_elemento,null)==false && $this->cod_tipo_elemento !=0){
            $this->setError("cod_tipo_elemento", "Código de tipo elemento no existe");
        }
    }

    //para el tema de la descripcion
    function obtenidoCodTipo(){
         if ($this->cod_tipo_elemento == 0) {
            $this->descripcion_tipo = "Sin indicar";
        } else {
            $lista = Listas::listaTipoElemento();
            if (array_key_exists($this->cod_tipo_elemento, $lista)) {
                $this->descripcion_tipo = $lista[$this->cod_tipo_elemento];
            } else {
                $this->setError("descripcion_tipo", "Código de tipo elemento no válido");
            }
        }
        
    }


    //para el tema de la fecha 
    function validaFecha(){
        $campo = "fecha_reconocimiento";
        $valor = $this->$campo;

        // Convertir formato si viene como YYYY-MM-DD
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $valor)) {
            $valor = date("d/m/Y", strtotime($valor));
            $this->$campo = $valor;
        }

        $fecha = DateTime::createFromFormat('d/m/Y', $valor);
        if ($fecha === false) {
            $this->setError($campo, "La fecha no tiene un formato válido (dd/mm/yyyy)");
            return;
        }

        $hoy = new DateTime("today");
        $min = new DateTime("1973-01-01");

        if ($this->reconocido_unesco == 1) {
            if ($fecha > $hoy || $fecha < $min) {
                $this->setError($campo, "La fecha debe estar entre 01/01/1973 y hoy");
            }
        } else {
            if ($fecha >= $hoy) {
                $this->setError($campo, "La fecha debe ser menor que hoy");
            }
            // Si no tiene UNESCO, se deja la fecha por defecto
            $fechaDefecto = new DateTime("1958-07-15");
            $this->fecha_reconocimiento = $fechaDefecto->format("d/m/Y");
        }
    }
        
}



