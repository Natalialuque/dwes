<?php
//Incluir la librería de validaciones 
include_once(dirname(__FILE__) . "/../librerias/validacion.php");

class Proyecto
{

    //Constante pública
    const TIPOPROYECTO = [
        10 => "Solo software",
        20 => "Solo hardware",
        30 => "Software/Hardware",
    ];

    //propiedades de la clase
    //llegada por entrada
    protected string $_nombre;
    protected string $_empresa;
    protected string $_fecha_inicio = "";
    protected string $_fecha_fin = "";
    protected int $_tipo = 10;


    //Propiedadas calculadas
    protected string $_tipo_descripcion = "";
    protected int $_duracion;

    //soporte para Otras
    private Otras $_otras;

    /**
     * Constructor de la clase Proyecto
     *
     * @param string $nombre
     * @param string $empresa
     * @param string $fechaInicio
     * @param string $fechaFin
     * @param integer $tipo
     */
    public function __construct(string $nombre, string $empresa, string $fechaInicio = "", string $fechaFin = "",  int $tipo = 10)
    {

        if ($this->setNombre($nombre) != 0) {

            throw new Exception("La propiedad nombre es obligatoria y tiene que tener 40 carac. Máx");
        } else $this->_nombre = $nombre;

        if ($this->setEmpresa($nombre) != 0) {

            throw new Exception("La propiedad empresa es obligatoria y tiene que tener 35 carac. Máx");
        } else $this->_empresa = $empresa;

        $fechaHoy = new Datetime();

        if ($this->setFechaIni($fechaInicio) != 0) {
            $this->_fecha_inicio = $fechaHoy->format("d/m/y");
        }


        if ($this->setFechaFin($fechaFin) != 0) {
            $this->_fecha_fin = date('d/m/y', strtotime("+6 month"));
        }

        //Calcular duración
        $fechaI = new DateTime($this->_fecha_inicio);
        $fechaF = new DateTime($this->_fecha_fin);
        $interval = $fechaI->diff($fechaF);
        $duracion = $interval->->format('%d');


        $this->_duracion = intval($duracion);

        //Validar el tipo de proyecto
        if ($this->setTipo($tipo)!=0){
            $this->_tipo = 10;
        } else $this->_tipo = $tipo;


        $this->_tipo_descripcion = $this::TIPOPROYECTO[$this->_tipo];
        $this->_otras = new Otras;
    }


    /** GETTERS Y SETTERS */
    public function getNombre()
    {
        return $this->_nombre;
    }

    public function setNombre($nombre): int
    {
        if (!validaCadena($nombre, 40, $nombre))
            return -2;
        if (trim($nombre) == "") return -1;
        $this->_nombre = $nombre;
        return 0;
    }

    public function getEmpresa()
    {
        return $this->_empresa;
    }

    public function setEmpresa($empresa): bool
    {
        if (!validaCadena($empresa, 35, $empresa)) return -2;
        if (trim($empresa) == "") return -1;
        $this->_empresa = $empresa;
        return 0;
    }


    public function getFechaIni()
    {
        return $this->_fecha_inicio;
    }

    public function setFechaIni($fecha): bool
    {
        $fechaHoy = new Datetime();

        if (!validaFecha($fecha, $fechaHoy->format("d/m/y")))
            return -1;
        if (!comprobarFecha($fecha)) return -2;

        $this->_fecha_inicio = $fecha;
        return 0;
    }


    public function getFechaFin()
    {
        return $this->_fecha_fin;
    }

    public function setFechaFin($fecha): bool
    {

        if (!validaFecha($fecha, date('d/m/y', strtotime("+6 month")))) return -1;
        if (!compararFechas($this->_fecha_inicio, $this->_fecha_fin)) return -2;
        $this->_fecha_fin = $fecha;
        return 0;
    }



    public function getTipo()
    {
        return $this->_tipo;
    }

    public function setTipo($tipo): bool
    {

        if (!validaEntero($tipo, 10, 30, 10))
            return -1;
        if (!validaRango($tipo, $this::TIPOPROYECTO, 2)) return -2;
        else $this->_tipo = $tipo;
        return 0;
    }


    public function getDuracion()
    {
        return $this->_duracion;
    }



    public function getTipoDescripcion()
    {
        return $this->_tipo_descripcion;
    }



    //Sobrecarga dinámica

    public function __set(string $nombre, mixed $value)
    {
        throw new Exception("No permite la propiedad" . $nombre);
    }

    public function __get(string $nombre)
    {
        throw new Exception("No permite la propiedad" . $nombre);
    }

    public function __isset(string $nombre)
    {
        return false;
    }


    /**
     * toString de la clase Proyecto
     *
     * @return string
     */
    public function __toString()
    {
        return "Proyecto " . $this->getNombre() .
            " para " . $this->getEmpresa() .
            " que durará " . $this->getDuracion() .
            " dias entre " . $this->_fecha_inicio . " y " . $this->_fecha_fin .
            " de tipo " . $this->_tipo_descripcion;
    }


    /**
     * Función para el añadir propiedades dinámicas
     *
     * @param string $propiedad
     * @param mixed $valor
     * @param integer $n_prop
     * @param [type] ...$valoresPropiedades
     * @return boolean
     */
    public function aniadeOtras(string $propiedad, mixed $valor, int $n_prop, ...$valoresPropiedades): bool
    {

        $contador = 0;
        try {
            $this->_otras->$propiedad = $valor;
            $contador++;
        } catch (Exception $e) {
        }

        if (count($valoresPropiedades) > 1) { //añadimos el resto

            if (count($valoresPropiedades) % 2 == 0) {
                $pares = count($valoresPropiedades);
            } else {
                $pares = count($valoresPropiedades) - 1;
            }

            for ($i = 0; $i < $pares; $i = $i + 2) {
                $key = $valoresPropiedades[$i];
                $this->propie->$key = $valoresPropiedades[$i + 1];
                $contador++;
            }
        }

        $n_prop = $contador;
        return ($n_prop > 0);
    }

    /**
     * Función que devuelve una cadena con todas las propiedades _otras
     *
     * @return void
     */
    public function getDescripcionOtras()
    {
        return $this->_otras;
    }
}
