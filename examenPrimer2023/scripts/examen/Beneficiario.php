<?php

class Beneficiario
{
    // Tipos de reduccion permitidos por el enunciado.
    private const TIPOSREDUCCION = [
        1 => "Sin reduccion",
        2 => "Discapacidad",
        3 => "Familia numerosa",
    ];

    // Propiedades protegidas: no se acceden desde fuera, pero si desde clases hijas.
    protected string $_nombre;
    protected string $_nif;
    protected int $_reduccion;
    protected string $_reduccion_texto;
    protected string $_fecha_nacimiento;
    protected int $_mayor_edad = 0;

    private Bonos $_bonos;

    public function __construct(string $nombre, string $nif, int $reduccion = 1, string $fecha_nacimiento = "")
    {
        // Contamos cuantos datos no cumplen restricciones para lanzar excepcion si son 2 o mas.
        $errores = 0;

        // Cada beneficiario empieza teniendo su propio objeto Bonos.
        $this->_bonos = new Bonos();

        // Si un dato no cumple, se deja un valor por defecto y se suma un error.
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

        // El enunciado pide excepcion si fallan dos o mas propiedades.
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

        // Nombre obligatorio y de 30 caracteres como maximo.
        if ($nombre === "" || !validaCadena($nombre, 30, "")) {
            return false;
        }

        $this->_nombre = $nombre;
        return true;
    }

    public function setNif(string $nif): bool
    {
        $nif = mb_strtoupper(trim($nif));

        // Formatos permitidos: 99999999A o A9999999A.
        $expresion = "/^([0-9]{8}[A-Z]|[A-Z][0-9]{7}[A-Z])$/";

        if (!validaExpresion($nif, $expresion, "")) {
            return false;
        }

        $this->_nif = $nif;
        return true;
    }

    public function setReduccion(int $reduccion): bool
    {
        // Solo se aceptan las claves existentes en TIPOSREDUCCION.
        if (!array_key_exists($reduccion, self::TIPOSREDUCCION)) {
            return false;
        }

        // Se guarda el numero y tambien el texto asociado.
        $this->_reduccion = $reduccion;
        $this->_reduccion_texto = self::TIPOSREDUCCION[$reduccion];
        return true;
    }

    public function setFechaNacimiento(string $fecha_nacimiento): bool
    {
        $fecha_nacimiento = trim($fecha_nacimiento);

        // Si no se indica fecha, se pone por defecto hace 10 anos.
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

        // La fecha no puede ser posterior a hoy.
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
        // No se permite crear propiedades dinamicas en Beneficiario.
        throw new Exception("No se permite crear la propiedad $name.");
    }

    public function __get(string $name): mixed
    {
        // Tampoco se permite leer propiedades no declaradas desde fuera.
        throw new Exception("No se permite acceder a la propiedad $name.");
    }

    public function __isset(string $name): bool
    {
        return false;
    }

    public function aniadeBonos(int &$nbonos, string $bono, string $valor, mixed ...$resto): bool
    {
        // Este parametro se devuelve por referencia con el numero de bonos insertados.
        $nbonos = 0;

        // Unimos el primer par bono-valor con todos los demas pares recibidos.
        $datos = array_merge([$bono, $valor], $resto);

        for ($i = 0; $i < count($datos); $i += 2) {
            if (!isset($datos[$i + 1])) {
                continue;
            }

            try {
                // No validamos manualmente el bono: lo intenta guardar Bonos y alli se controla.
                $numero = (string)$datos[$i];
                $importe = $datos[$i + 1];
                if (is_string($importe) && ctype_digit($importe)) {
                    $importe = intval($importe);
                }
                $this->_bonos->$numero = $importe;
                $nbonos++;
            } catch (Exception $e) {
                // Si un bono falla, se ignora y se sigue con los demas.
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

        // Recorremos Bonos con foreach, saltando la primera posicion "importe".
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
        // Calculamos la edad con DateTime y guardamos 1 si tiene 18 o mas.
        $fecha = DateTime::createFromFormat("d/m/Y", $this->_fecha_nacimiento);
        $hoy = new DateTime();
        $this->_mayor_edad = ($fecha !== false && $fecha->diff($hoy)->y >= 18) ? 1 : 0;
    }

    public function __toString(): string
    {
        // Texto exacto que se muestra cuando se imprime el objeto como cadena.
        $mayor = $this->_mayor_edad ? "es Mayor de edad" : "no es Mayor de edad";

        return "Beneficiario " . $this->_nombre .
            " con nif " . $this->_nif .
            " que nacio el " . $this->_fecha_nacimiento .
            ", que " . $mayor .
            " y tiene reduccion " . $this->_reduccion_texto . ".";
    }
}
