<?php

class Libro implements Iterator {
    private $_nombre;
    private $_autor;
    private $_otras = [];
    private $_posicion = 0;

    public function __construct(string $nombre, string $autor, ...$parametros) {
        $this->_nombre = $nombre;
        $this->_autor = $autor;

        for ($i = 0; $i < count($parametros); $i += 2) {
            $nombreProp = $parametros[$i];
            $valorProp = isset($parametros[$i + 1]) ? $parametros[$i + 1] : null;

            if (is_string($nombreProp)) {
                $this->__set($nombreProp, $valorProp);
            }
        }
    }

    // Formatea el nombre de la propiedad: minúsculas + última en mayúscula
    private function formatearNombreInterno($name) {
        return strtolower(substr($name, 0, -1)) . strtoupper(substr($name, -1));
    }

    public function __set($name, $value) {
        $nameLower = strtolower($name);
        if ($nameLower === 'nombre') {
            $this->_nombre = $value;
        } elseif ($nameLower === 'autor') {
            $this->_autor = $value;
        } else {
            $formateado = $this->formatearNombreInterno($name);
            $this->_otras[$formateado] = $value;
        }
    }

    public function __get($name) {
        $nameLower = strtolower($name);
        if ($nameLower === 'nombre') return $this->_nombre;
        if ($nameLower === 'autor') return $this->_autor;

        foreach ($this->_otras as $key => $valor) {
            if (strtolower($key) === $nameLower) {
                return $valor;
            }
        }
        return null;
    }

    /**
     * Se activa al usar isset() o empty() sobre propiedades no accesibles.
     */
    public function __isset($name) {
        $nameLower = strtolower($name);
        if ($nameLower === 'nombre') return isset($this->_nombre);
        if ($nameLower === 'autor') return isset($this->_autor);

        foreach ($this->_otras as $key => $valor) {
            if (strtolower($key) === $nameLower) {
                return isset($this->_otras[$key]);
            }
        }
        return false;
    }

    /**
     * Se activa al usar unset() sobre propiedades no accesibles.
     */
    public function __unset($name) {
        $nameLower = strtolower($name);
        if ($nameLower === 'nombre') {
            unset($this->_nombre);
        } elseif ($nameLower === 'autor') {
            unset($this->_autor);
        } else {
            foreach ($this->_otras as $key => $valor) {
                if (strtolower($key) === $nameLower) {
                    unset($this->_otras[$key]);
                    break;
                }
            }
        }
    }

    // --- Métodos de Iterator ---
    public function rewind(): void { $this->_posicion = 0; }
    
    public function current(): mixed {
        if ($this->_posicion === 0) return $this->_nombre;
        $totalOtras = count($this->_otras);
        if ($this->_posicion <= $totalOtras) {
            $keys = array_keys($this->_otras);
            return $this->_otras[$keys[$this->_posicion - 1]];
        }
        return $this->_autor;
    }

    public function key(): mixed {
        if ($this->_posicion === 0) return 'nombre';
        $totalOtras = count($this->_otras);
        if ($this->_posicion <= $totalOtras) {
            $keys = array_keys($this->_otras);
            return strtolower($keys[$this->_posicion - 1]);
        }
        return 'autor';
    }

    public function next(): void { $this->_posicion++; }

    public function valid(): bool {
        return $this->_posicion >= 0 && $this->_posicion <= (count($this->_otras) + 1);
    }
}