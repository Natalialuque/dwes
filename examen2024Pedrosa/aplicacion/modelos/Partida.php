<?php

class Partida extends CActiveRecord {

    /*
     *  NOMBRE DEL MODELO
     */
    protected function fijarNombre(): string {
        return "partida";
    }

    /*
     *  ATRIBUTOS
     */
    protected function fijarAtributos(): array {
        return [
            "cod_partida",
            "mesa",
            "fecha",
            "cod_baraja",
            "nombre_baraja",
            "jugadores",
            "crupier"
        ];
    }

  

    /*
     *  DESCRIPCIONES (todas empiezan por "Parti-")
     */
    protected function fijarDescripciones(): array {
        return [
            "cod_partida"   => "Parti-Código de partida",
            "mesa"          => "Parti-Mesa",
            "fecha"         => "Parti-Fecha",
            "cod_baraja"    => "Parti-Código de baraja",
            "nombre_baraja" => "Parti-Nombre de la baraja",
            "jugadores"     => "Parti-Jugadores",
            "crupier"       => "Parti-Crupier"
        ];
    }

    /*
     *  RESTRICCIONES
     */
    protected function fijarRestricciones(): array {

        return [

            // Obligatorios
            [
                "ATRI" => "cod_partida,cod_baraja",
                "TIPO" => "REQUERIDO"
            ],

            // cod_partida entero y mayor de 20
            [
                "ATRI" => "cod_partida",
                "TIPO" => "ENTERO",
                "MIN"  => 21
            ],

            // mesa entre 1 y 20
            [
                "ATRI" => "mesa",
                "TIPO" => "ENTERO",
                "MIN"  => 1,
                "MAX"  => 20
            ],

            // fecha no anterior a hoy
            [
                "ATRI" => "fecha",
                "TIPO" => "FECHA",
                "FECHA_MIN" => date("Y-m-d")
            ],

            // cod_baraja debe ser válido según Listas
            [
                "ATRI" => "cod_baraja",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarCodigoBaraja"
            ],

            // nombre_baraja cadena 30
            [
                "ATRI" => "nombre_baraja",
                "TIPO" => "CADENA",
                "TAMANIO" => 30
            ],

            // jugadores depende del tipo de baraja
            [
                "ATRI" => "jugadores",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarJugadores"
            ],

            // crupier cadena 30
            [
                "ATRI" => "crupier",
                "TIPO" => "CADENA",
                "TAMANIO" => 30
            ],

            // crupier debe empezar por Cru-
            [
                "ATRI" => "crupier",
                "TIPO" => "PATRON",
                "PATRON" => "/^Cru-.+/"
            ]
        ];
    }

    /*
     *  VALIDACIÓN cod_baraja
     */
    protected function validarCodigoBaraja() {

        $lista = Listas::listaTiposBarajas(true);

        if (!isset($lista[$this->cod_baraja])) {
            $this->setError("cod_baraja", "El código de baraja no es válido.");
            return;
        }

        // Actualizar nombre_baraja automáticamente
        $this->nombre_baraja = $lista[$this->cod_baraja]["nombre"];
    }
    /**
     * VALIDAR FECHA
     *
     * @return void
     */
    public function validaFecha() {
        $hoy = date("Y-m-d");
        if($this->fecha<$hoy)
             $this->setError("fecha", "La fecha debe ser igual o mayor a hoy");
    }
    /*
     *  VALIDACIÓN jugadores según min/max del tipo de baraja
     */
    protected function validarJugadores() {

        $lista = Listas::listaTiposBarajas(true);

        if (!isset($lista[$this->cod_baraja])) {
            return; // ya lo valida validarCodigoBaraja
        }

        $min = $lista[$this->cod_baraja]["min_juga"];
        $max = $lista[$this->cod_baraja]["max_juga"];

        if ($this->jugadores < $min || $this->jugadores > $max) {
            $this->setError("jugadores", "El número de jugadores debe estar entre $min y $max.");
        }
    }

    /*
     *  VALORES POR DEFECTO (afterCreate)
     *  Deben asignarse inicialmente los valores por defecto cuando se cree un  objeto de este modelo.
     */
    protected function afterCreate(): void {

    $lista = Listas::listaTiposBarajas(true);
    $codigos = array_keys($lista);

    $cod_defecto = $codigos[floor(count($codigos) / 2)];
    $nombre_defecto = $lista[$cod_defecto]["nombre"];
    $jug_min = $lista[$cod_defecto]["min_juga"];

    if ($this->mesa === null) {
        $this->mesa = 1;
    }

    if ($this->fecha === null) {
        $this->fecha = date("Y-m-d", strtotime("+1 day"));
    }

    if ($this->cod_baraja === null) {
        $this->cod_baraja = $cod_defecto;
    }

    if ($this->nombre_baraja === null) {
        $this->nombre_baraja = $nombre_defecto;
    }

    if ($this->jugadores === null) {
        $this->jugadores = $jug_min;
    }

    if ($this->crupier === null) {
        $this->crupier = "Cru-Juan";
    }
}

}
