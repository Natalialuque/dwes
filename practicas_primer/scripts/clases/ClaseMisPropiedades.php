<?php

class ClaseMisPropiedades implements Iterator
{
    private array $_propiedades = [];
    public mixed $propPublica;
    private mixed $_propPrivada = 25;

    private int $_posicion = 0;
    private array $_clavesIterables = [];

    public function __set(string $nombre, mixed $valor): void
    {
        if ($nombre === '_propPrivada') {
            // Alternativa sin throw: ignorar o mostrar aviso
            echo "No se puede asignar dinámicamente a '$nombre'.<br>";
            return;
        }

        $this->_propiedades[$nombre] = $valor;
    }

    public function __get(string $nombre): mixed
    {
        if (array_key_exists($nombre, $this->_propiedades)) {
            return $this->_propiedades[$nombre];
        }

        // Alternativa sin throw: devolver null o mensaje
        echo "La propiedad '$nombre' no está definida.<br>";
        return null;
    }

    public function __isset(string $nombre): bool
    {
        return isset($this->_propiedades[$nombre]);
    }

    public function rewind(): void
    {
        $this->_clavesIterables = array_keys($this->_propiedades);
        $this->_clavesIterables[] = 'propPublica';
        $this->_clavesIterables[] = '_propPrivada';
        $this->_posicion = 0;
    }

    public function current(): mixed
    {
        $clave = $this->_clavesIterables[$this->_posicion];

        return match ($clave) {
            'propPublica' => $this->propPublica,
            '_propPrivada' => $this->_propPrivada,
            default => $this->_propiedades[$clave] ?? null,
        };
    }

    public function key(): string
    {
        return 'oi_' . $this->_clavesIterables[$this->_posicion];
    }

    public function next(): void
    {
        $this->_posicion++;
    }

    public function valid(): bool
    {
        return $this->_posicion < count($this->_clavesIterables);
    }
}


?>