<?php
class Otras implements Iterator
{
    // Propiedad privada
    private float $_TOTAL_IMPORTES = 0;

    // Propiedades dinámicas
    private array $propie = [];

    // Puntero del iterador
    private int $_posIte = 0;
    private array $_claves = [];

    // Constructor
    public function __construct() {
        $this->_TOTAL_IMPORTES = 0;
        $this->propie = [];
        $this->actualizarClaves();
    }

    // Método para actualizar claves del iterador
    private function actualizarClaves(): void {
        $this->_claves = array_merge(['tot_imp'], array_keys($this->propie));
    }

    // __set: asigna dinámicamente propiedades
    public function __set(string $nombre, mixed $valor): void {
        $clave = mb_strtoupper($nombre);

        //usar validación
        if (preg_match('/^i/i', $clave)) {
            // Propiedad numérica
            if (!is_numeric($valor)) {
                $valor = 0;
            }
            $valor = floatval($valor);
            $this->propie[$clave] = $valor;
            $this->_TOTAL_IMPORTES += $valor;
        } else {
            // Propiedad tipo cadena
            $this->propie[$clave] = strval($valor);
        }

        $this->actualizarClaves();
    }

    // __get: accede a propiedades dinámicas o tot_imp
    public function __get(string $nombre): mixed {
        $clave = mb_strtoupper($nombre);

        if ($clave === 'TOT_IMP') {
            return $this->_TOTAL_IMPORTES;
        }

        if (isset($this->propie[$clave])) {
            return $this->propie[$clave];
        }

        throw new Exception("Propiedad '$nombre' no definida.");
    }

    // __isset: comprueba si existe la propiedad
    public function __isset(string $nombre): bool {
        $clave = mb_strtoupper($nombre);
        return $clave === 'TOT_IMP' || isset($this->propie[$clave]);
    }

    // __unset: elimina propiedad dinámica
    public function __unset(string $nombre): void {
        $clave = mb_strtoupper($nombre);
        if (isset($this->propie[$clave])) {
            unset($this->propie[$clave]);
            $this->actualizarClaves();
        }
    }

    // Métodos del iterador
    public function rewind(): void {
        $this->_posIte = 0;
    }

    public function valid(): bool {
        return $this->_posIte < count($this->_claves);
    }

    public function current(): mixed {
        $clave = $this->_claves[$this->_posIte];
        return $clave === 'tot_imp' ? $this->_TOTAL_IMPORTES : $this->propie[$clave];
    }

    public function key(): mixed {
        $clave = $this->_claves[$this->_posIte];
        if ($clave === 'tot_imp') return 'Tot_imp';

        // Transformar clave: primera y última letra en mayúscula, resto minúscula
        $clave = mb_strtolower($clave);
        $len = mb_strlen($clave);
        return mb_strtoupper(mb_substr($clave, 0, 1)) .
               mb_substr($clave, 1, $len - 2) .
               mb_strtoupper(mb_substr($clave, -1));
    }

    public function next(): void {
        $this->_posIte++;
    }

    // toString: muestra claves dinámicas
    public function __toString(): string {
        $cadena = "tot_imp - ";
        foreach ($this->propie as $key => $value) {
            $cadena .= $key . " - ";
        }
        return rtrim($cadena, " - ");
    }
}
?>


?>