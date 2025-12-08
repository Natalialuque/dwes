<?php
//Incluir la librería de validaciones 
include_once(dirname(__FILE__) . "/../librerias/validacion.php");

class Poryecto
{


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

    // //soporte para bonos
    // private Bonos $_bono;



    /**
     * Contructor de la clase Proyecto con todos sus datos.
     * 
     * A partir de los datos obtenidos de se cargan las propiedades $_tipo_descripcion
     *
     *
     */
    public function __construct(string $nombre, string $empresa, int $fechainicio = 1, string $fechaInicio = "", string $fechaFin = "",  int $tipo)
    {


        if (!validaCadena($nombre, 40, $nombre) || trim($nombre) == "") {

            throw new Exception("La propiedad nombre es obligatoria y tiene que tener 40 carac. Máx");
        } else $this->_nombre = $nombre;

        if (!validaCadena($empresa, 35, $empresa) || trim($empresa) == "") {

            throw new Exception("La propiedad empresa es obligatoria y tiene que tener 35 carac. Máx");
        } else $this->_empresa = $empresa;

        $fechaHoy = new Datetime();

        if (!validaFecha($fechaInicio, $fechaHoy->format("d/m/y")) || !comprobarFecha($fechaInicio)) {
            $this->_fecha_inicio = $fechaHoy->format("d/m/y");
        }

        $this->_fecha_inicio = $fechaInicio;


        if (!validaFecha($fechaFin, date('d/m/y', strtotime("+6 month"))) || !compararFechas($fechaInicio, $fechaFin)) {
            $this->_fecha_fin = date('d/m/y', strtotime("+6 month"));
        }

        $this->_fecha_fin = $fechaFin;



        //Calcular duración
        $fechaI = new DateTime($this->_fecha_inicio);
        $fechaF = new DateTime($this->_fecha_fin);
        $interval =

            $interval = $fechaI->diff($fechaF);
        $duracion = $interval->format('%d');


        $this->_duracion = intval($duracion);

        if (!validaEntero($tipo, 10, 30, 10) || !validaRango($tipo, $this::TIPOPROYECTO, 2)) {
            $this->_tipo = 10;
        } else $this->_tipo = $tipo;


        $this->_tipo_descripcion= $this::TIPOPROYECTO[$this->_tipo];

    }


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
        return true;
    }

    public function getEmpresa()
    {
        return $this->_empresa;
    }

    public function setEmpresa($empresa): bool
    {
        if (!validaCadena($empresa, 35, $empresa) || trim($empresa) == "") {
            return false;
        } else $this->_empresa = $empresa;
        return true;
    }


    public function getFechaIni()
    {
        return $this->_fecha_inicio;
    }

    public function setFechaIni($fecha): bool
    {
        $fechaHoy = new Datetime();

        if (!validaFecha($fecha, $fechaHoy->format("d/m/y")) || !comprobarFecha($fecha)) {
            $this->_fecha_inicio = $fechaHoy->format("d/m/y");
        }
        $this->_fecha_inicio = $fecha;
        return true;
    }


    public function getFechaFin()
    {
        return $this->_fecha_fin;
    }

    public function setFechaFin($fecha): bool
    {

        if (!validaFecha($fecha, date('d/m/y', strtotime("+6 month"))) || !compararFechas($this->_fecha_inicio, $this->_fecha_fin)) {
            $this->_fecha_fin = date('d/m/y', strtotime("+6 month"));
        }

        $this->_fecha_fin = $fecha;
        return true;
    }



    public function getTipo()
    {
        return $this->_tipo;
    }

    public function setTipo($tipo): bool
    {

        if (!validaEntero($tipo, 10, 30, 10) || !validaRango($tipo, $this::TIPOPROYECTO, 2)) {
            $this->_tipo = 10;
        } else $this->_tipo = $tipo;
        return true;
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
     * toString clase Beneficiario
     *
     * @return string
     */
    public function __toString()
    {
        return "Proyecto " . $this->getNombre() .
            " para " . $this->getEmpresa() .
            " que durará " . $this->getDuracion() .
            " dias entre " . $this->_fecha_inicio . " y " . $this->_fecha_fin .
            " de tipo" . $this->_tipo_descripcion;
    }

//     //--------------------------------------------------------
//     //----------------------Métodos---------------------------
//     //--------------------------------------------------------

//     /**
//      * Agrega a los bonos el total de bonos que queramos agregar siendo mínimo uno
//      *
//      * @param integer $nBonos
//      * @param string $bonos
//      * @param string $valor
//      * @param [type] ...$valorBono
//      * @return bool
//      */
//     public function aniadeBonos(int &$nBonos, string $bonos, string $valor, ...$valorBono): bool
//     {

//         $contIngresos = 0;
//         $realizado = false;

//         try {
//             $this->_bono->$bonos = intval($valor);
//             $contIngresos++;
//         } catch (Exception $e) {
//         }

//         if (count($valorBono) > 1) { //añadimos el resto

//             if (count($valorBono) % 2 == 0) {
//                 $pares = count($valorBono);
//             } else {
//                 $pares = count($valorBono) - 1;
//             }

//             for ($i = 0; $i < $pares; $i = $i + 2) {
//                 try {
//                     $key = $valorBono[$i];
//                     $this->_bono->$key = intval($valorBono[$i + 1]);
//                     $contIngresos++;
//                 } catch (Exception $e) {
//                 }
//             }
//         }

//         $nBonos = $contIngresos; //actualizamos el número de ingresos realizado

//         return ($nBonos > 0);
//     }

//     /**
//      * Devuelve un array con el total de importes de los bonos
//      *
//      * @return array
//      */
//     public function getImporteBonos(): int
//     {

//         return $this->_bono->importe;
//     }

//     /**
//      * Devuelve un array copia con las keys y values de los listados de los bonos de la clase
//      *
//      * @return array
//      */
//     public function getListaBonos(): array
//     {
//         $lista = [];

//         foreach ($this->_bono as $key => $value) {
//             if ($key != "importe")
//                 $lista[$key] = $value;
//         }

//         return $lista;
//     }
}
