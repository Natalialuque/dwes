<?php

class Beneficiario
{
    private const TIPOSREDUCCION = [
        1 => "Sin reduccion",
        2 => "Discapacidad",
        3 => "Familia numerosa",
    ];

    protected string $_nombre;
    protected string $_nif;
    protected int $_reduccion;
    protected string $_reduccion_texto;
    protected string $_fecha_nacimiento;
    protected int $_mayor_edad = 0;

    private Bonos $_bonos;

    public function __construct(string $nombre, string $nif, int $reduccion = 1, string $fecha_nacimiento = "")
    {
        $errores = 0;
        $this->_bonos = new Bonos();

        if (!$this->setNombre($nombre)) {
            $this->_nombre = "Sin nombre";
            $errores++;
        }

        if (!$this->setNif($nif)) {
            $this->_nif = "00000000T";
            $errores++;
        }

        if (!$this->setReduccion($reduccion)) {
            $this->_reduccion = 1;
            $this->_reduccion_texto = self::TIPOSREDUCCION[1];
            $errores++;
        }

        if (!$this->setFechaNacimiento($fecha_nacimiento)) {
            $fecha = new DateTime();
            $fecha->modify("-10 years");
            $this->_fecha_nacimiento = $fecha->format("d/m/Y");
            $this->_mayor_edad = 0;
            $errores++;
        }

        if ($errores >= 2) {
            throw new Exception("Dos o mas propiedades no cumplen las restricciones.");
        }
    }

    public function getNombre(): string
    {
        return $this->_nombre;
    }

    public function getNif(): string
    {
        return $this->_nif;
    }

    public function getReduccion(): int
    {
        return $this->_reduccion;
    }

    public function getReduccionTexto(): string
    {
        return $this->_reduccion_texto;
    }

    public function getFechaNacimiento(): string
    {
        return $this->_fecha_nacimiento;
    }

    public function getMayorEdad(): int
    {
        return $this->_mayor_edad;
    }

    public function setNombre(string $nombre): bool
    {
        $nombre = trim($nombre);

        if ($nombre === "" || !validaCadena($nombre, 30, "")) {
            return false;
        }

        $this->_nombre = $nombre;
        return true;
    }

    public function setNif(string $nif): bool
    {
        $nif = mb_strtoupper(trim($nif));
        $expresion = "/^([0-9]{8}[A-Z]|[A-Z][0-9]{7}[A-Z])$/";

        if (!validaExpresion($nif, $expresion, "")) {
            return false;
        }

        $this->_nif = $nif;
        return true;
    }

    public function setReduccion(int $reduccion): bool
    {
        if (!array_key_exists($reduccion, self::TIPOSREDUCCION)) {
            return false;
        }

        $this->_reduccion = $reduccion;
        $this->_reduccion_texto = self::TIPOSREDUCCION[$reduccion];
        return true;
    }

    public function setFechaNacimiento(string $fecha_nacimiento): bool
    {
        $fecha_nacimiento = trim($fecha_nacimiento);

        if ($fecha_nacimiento === "") {
            $fecha = new DateTime();
            $fecha->modify("-10 years");
            $this->_fecha_nacimiento = $fecha->format("d/m/Y");
            $this->calcularMayorEdad();
            return true;
        }

        if (!validaFecha($fecha_nacimiento, "")) {
            return false;
        }

        $fecha = DateTime::createFromFormat("d/m/Y", $fecha_nacimiento);
        $hoy = new DateTime();
        $hoy->setTime(23, 59, 59);

        if ($fecha > $hoy) {
            return false;
        }

        $this->_fecha_nacimiento = $fecha_nacimiento;
        $this->calcularMayorEdad();
        return true;
    }

    public function __set(string $name, mixed $value): void
    {
        throw new Exception("No se permite crear la propiedad $name.");
    }

    public function __get(string $name): mixed
    {
        throw new Exception("No se permite acceder a la propiedad $name.");
    }

    public function __isset(string $name): bool
    {
        return false;
    }

    public function aniadeBonos(int &$nbonos, string $bono, string $valor, mixed ...$resto): bool
    {
        $nbonos = 0;
        $datos = array_merge([$bono, $valor], $resto);

        for ($i = 0; $i < count($datos); $i += 2) {
            if (!isset($datos[$i + 1])) {
                continue;
            }

            try {
                $numero = (string)$datos[$i];
                $importe = $datos[$i + 1];
                if (is_string($importe) && ctype_digit($importe)) {
                    $importe = intval($importe);
                }
                $this->_bonos->$numero = $importe;
                $nbonos++;
            } catch (Exception $e) {
            }
        }

        return $nbonos > 0;
    }

    public function getImporteBonos(): int
    {
        return $this->_bonos->importe;
    }

    public function getListaBonos(): array
    {
        $lista = [];

        foreach ($this->_bonos as $clave => $valor) {
            if ($clave !== "importe") {
                $lista[$clave] = $valor;
            }
        }

        return $lista;
    }

    public function getBonos(): Bonos
    {
        return $this->_bonos;
    }

    private function calcularMayorEdad(): void
    {
        $fecha = DateTime::createFromFormat("d/m/Y", $this->_fecha_nacimiento);
        $hoy = new DateTime();
        $this->_mayor_edad = ($fecha !== false && $fecha->diff($hoy)->y >= 18) ? 1 : 0;
    }

    public function __toString(): string
    {
        $mayor = $this->_mayor_edad ? "es Mayor de edad" : "no es Mayor de edad";

        return "Beneficiario " . $this->_nombre .
            " con nif " . $this->_nif .
            " que nacio el " . $this->_fecha_nacimiento .
            ", que " . $mayor .
            " y tiene reduccion " . $this->_reduccion_texto . ".";
    }
}
