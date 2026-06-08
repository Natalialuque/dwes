<?php
class Parada extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return "parada";
    }

    protected function fijarAtributos(): array
    {
        return ["cod_trayecto", "nombreTrayecto", "estacion", "poblacion", "es_origen"];
    }

    protected function fijarDescripciones(): array
    {
        return [
            "cod_trayecto" => "Para-cod_trayecto",
            "nombreTrayecto" => "Para-nombreTrayecto",
            "estacion" => "Para-estacion",
            "poblacion" => "Para-poblacion",
            "es_origen" => "Para-es_origen",
        ];
    }

    protected function fijarRestricciones(): array
    {
        return [
            [
                "ATRI" => "cod_trayecto",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "El codigo de trayecto es obligatorio",
            ],
            [
                "ATRI" => "cod_trayecto",
                "TIPO" => "ENTERO",
                "MENSAJE" => "El codigo de trayecto debe ser entero",
            ],
            [
                "ATRI" => "cod_trayecto",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaTrayecto",
            ],
            [
                "ATRI" => "nombreTrayecto",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "MENSAJE" => "El nombre del trayecto no puede superar 30 caracteres",
            ],
            [
                "ATRI" => "nombreTrayecto",
                "TIPO" => "FUNCION",
                "FUNCION" => "rellenaNombreTrayecto",
            ],
            [
                "ATRI" => "estacion",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "La estacion es obligatoria",
            ],
            [
                "ATRI" => "estacion",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "MENSAJE" => "La estacion no puede superar 30 caracteres",
            ],
            [
                "ATRI" => "poblacion",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "La poblacion es obligatoria",
            ],
            [
                "ATRI" => "poblacion",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "MENSAJE" => "La poblacion no puede superar 30 caracteres",
            ],
            [
                "ATRI" => "poblacion",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaPoblacion",
            ],
            [
                "ATRI" => "es_origen",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX" => 1,
                "MENSAJE" => "Origen debe ser 0 o 1",
            ],
        ];
    }

    protected function afterCreate(): void
    {
        $codigos = array_keys(Lista::listaTrayectos());
        $posicionMedia = intdiv(count($codigos), 2);

        $this->cod_trayecto = $codigos[$posicionMedia];
        $this->nombreTrayecto = Lista::listaTrayectos(false, $this->cod_trayecto);
        $this->estacion = "-";
        $this->poblacion = $this->poblacionPorDefecto();
        $this->es_origen = 0;
    }

    public function validaTrayecto(): void
    {
        if (Lista::listaTrayectos(false, intval($this->cod_trayecto)) === false) {
            $this->setError("cod_trayecto", "El codigo de trayecto no existe");
        }
    }

    public function rellenaNombreTrayecto(): void
    {
        $nombre = Lista::listaTrayectos(false, intval($this->cod_trayecto));
        if ($nombre === false) {
            $this->setError("nombreTrayecto", "No se puede obtener el nombre del trayecto");
            return;
        }

        $this->nombreTrayecto = $nombre;
    }

    public function validaPoblacion(): void
    {
        if (trim((string)$this->poblacion) === "") {
            $this->poblacion = $this->poblacionPorDefecto();
            $this->setError("poblacion", "La poblacion se ha obtenido por defecto");
        }
    }

    private function poblacionPorDefecto(): string
    {
        return "Poblacion sin indicar";
    }
}
