<?php

class Bonos implements Iterator
{
    private const IMPORTE_MAXIMO = 100;

    private int $_importe_total = 0;
    private array $_misBonos = [];
    private int $_puntero = 0;

    public function __set(string $name, mixed $value): void
    {
        if ($name === "importe") {
            return;
        }

        if (!ctype_digit($name)) {
            throw new Exception("El numero de bono debe ser entero.");
        }

        if (!is_int($value)) {
            throw new Exception("El importe del bono debe ser entero.");
        }

        $clave = "B" . $name;
        $importeAnterior = $this->_misBonos[$clave] ?? 0;
        $nuevoTotal = $this->_importe_total - $importeAnterior + $value;

        if ($nuevoTotal > self::IMPORTE_MAXIMO) {
            throw new Exception("Se supera el importe maximo permitido.");
        }

        $this->_misBonos[$clave] = $value;
        $this->_importe_total = $nuevoTotal;
    }

    public function __get(string $name): mixed
    {
        if ($name === "importe") {
            return $this->_importe_total;
        }

        if (ctype_digit($name)) {
            $clave = "B" . $name;
            return $this->_misBonos[$clave] ?? null;
        }

        throw new Exception("La propiedad $name no es valida.");
    }

    public function __isset(string $name): bool
    {
        if ($name === "importe") {
            return true;
        }

        if (ctype_digit($name)) {
            return isset($this->_misBonos["B" . $name]);
        }

        return false;
    }

    public function __unset(string $name): void
    {
        if ($name === "importe") {
            return;
        }

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
        $this->_puntero = 0;
    }

    public function current(): mixed
    {
        if ($this->_puntero === 0) {
            return $this->_importe_total;
        }

        return array_values($this->_misBonos)[$this->_puntero - 1];
    }

    public function key(): mixed
    {
        if ($this->_puntero === 0) {
            return "importe";
        }

        return array_keys($this->_misBonos)[$this->_puntero - 1];
    }

    public function next(): void
    {
        $this->_puntero++;
    }

    public function valid(): bool
    {
        return $this->_puntero <= count($this->_misBonos);
    }
}
