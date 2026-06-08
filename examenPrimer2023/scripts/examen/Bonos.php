<?php

class Bonos implements Iterator
{
    // Importe maximo que puede sumar un beneficiario entre todos sus bonos.
    private const IMPORTE_MAXIMO = 100;

    // Guarda la suma de todos los bonos dados de alta.
    private int $_importe_total = 0;

    // Array asociativo donde se guardan los bonos: Bnumero => importe.
    private array $_misBonos = [];

    // Puntero usado por los metodos de Iterator para recorrer el objeto con foreach.
    private int $_puntero = 0;

    public function __set(string $name, mixed $value): void
    {
        // La propiedad dinamica importe es solo de lectura, por eso no modificamos nada.
        if ($name === "importe") {
            return;
        }

        // El nombre dinamico debe ser un numero entero: $bonos->235.
        if (!ctype_digit($name)) {
            throw new Exception("El numero de bono debe ser entero.");
        }

        // El importe tiene que ser entero; si no lo es, se lanza excepcion.
        if (!is_int($value)) {
            throw new Exception("El importe del bono debe ser entero.");
        }

        // Internamente se guarda con B delante, por ejemplo B235.
        $clave = "B" . $name;
        $importeAnterior = $this->_misBonos[$clave] ?? 0;
        $nuevoTotal = $this->_importe_total - $importeAnterior + $value;

        // No se permite guardar el bono si se supera el maximo de 100.
        if ($nuevoTotal > self::IMPORTE_MAXIMO) {
            throw new Exception("Se supera el importe maximo permitido.");
        }

        // Guardamos el bono y dejamos actualizado el importe total.
        $this->_misBonos[$clave] = $value;
        $this->_importe_total = $nuevoTotal;
    }

    public function __get(string $name): mixed
    {
        // Permite leer $bonos->importe sin que exista una propiedad real llamada importe.
        if ($name === "importe") {
            return $this->_importe_total;
        }

        // Permite leer un bono concreto usando su numero dinamico.
        if (ctype_digit($name)) {
            $clave = "B" . $name;
            return $this->_misBonos[$clave] ?? null;
        }

        throw new Exception("La propiedad $name no es valida.");
    }

    public function __isset(string $name): bool
    {
        // importe siempre se puede consultar aunque no este guardado como clave del array.
        if ($name === "importe") {
            return true;
        }

        // Para los bonos comprobamos si existe la clave Bnumero.
        if (ctype_digit($name)) {
            return isset($this->_misBonos["B" . $name]);
        }

        return false;
    }

    public function __unset(string $name): void
    {
        // importe no se puede borrar porque no esta guardado como propiedad dinamica.
        if ($name === "importe") {
            return;
        }

        // Si se borra un bono, tambien restamos su importe del total.
        if (ctype_digit($name)) {
            $clave = "B" . $name;
            if (isset($this->_misBonos[$clave])) {
                $this->_importe_total -= $this->_misBonos[$clave];
                unset($this->_misBonos[$clave]);
            }
        }
    }

    public function rewind(): void
    {
        // foreach llama aqui al empezar el recorrido.
        $this->_puntero = 0;
    }

    public function current(): mixed
    {
        // La primera posicion del recorrido debe ser el importe total.
        if ($this->_puntero === 0) {
            return $this->_importe_total;
        }

        // Despues del importe se devuelven los importes de cada bono.
        return array_values($this->_misBonos)[$this->_puntero - 1];
    }

    public function key(): mixed
    {
        // La primera clave del foreach sera importe.
        if ($this->_puntero === 0) {
            return "importe";
        }

        // Despues se devuelven las claves reales del array: B101, B102...
        return array_keys($this->_misBonos)[$this->_puntero - 1];
    }

    public function next(): void
    {
        // Avanzamos el puntero del recorrido.
        $this->_puntero++;
    }

    public function valid(): bool
    {
        // El recorrido es valido mientras quede importe o bonos por mostrar.
        return $this->_puntero <= count($this->_misBonos);
    }
}
