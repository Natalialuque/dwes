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

    protected int $_tipo =10;


    //Propiedadas calculadas
    protected string $_tipo_descripcion = "";
    protected int $_duracion ;

    // //soporte para bonos
    // private Bonos $_bono;



    /**
     * Contructor de la clase Proyecto con todos sus datos.
     * 
     * A partir de los datos obtenidos de se cargan las propiedades $_tipo_descripcion
     *
     *
     */
    public function __construct(string $nombre, string $empresa, int $fechainicio = 1, string $fechaInicio ="", string $fechaFin="",  int $tipo )
    {


        if (!validaCadena($nombre, 40, $nombre) || trim($nombre) == "") {

            throw new Exception("La propiedad nombre es obligatoria y tiene que tener 40 carac. Máx");
            
        }
        else $this->_nombre = $nombre;

        if (!validaCadena($empresa, 35, $empresa) || trim($empresa) == "") {

            throw new Exception("La propiedad empresa es obligatoria y tiene que tener 35 carac. Máx");
            
        }
        else $this->_empresa = $empresa;
        
        $fechaHoy = new Datetime();
        
        if (!validaFecha($fechaInicio ,$fechaHoy->format("d/m/y")) || !comprobarFecha($fechaInicio)){
            $this->_fecha_inicio = $fechaInicio;
        }

        $this->_fecha_inicio = $fechaInicio;


        if(!validaFecha($fechaFin,date('d/m/y',strtotime("+6 month"))) || !compararFechas($fechaInicio, $fechaFin)){
            $this->_fecha_fin = $fechaFin;
        }

        $this->_fecha_fin = $fechaFin;



        //Calcular duración
        $fechaI = new DateTime($this->_fecha_inicio);
        $fechaF = new DateTime($this->_fecha_fin);
        $interval = 

        $interval = $fechaI->diff($fechaF);
        $duracion = $interval->format('%d');


        $this->_duracion = intval($duracion);

        if (!validaEntero($tipo, 10, 30, 10)|| !validaRango($tipo, TIPOPROYEXTO)))
            $this->_reduccion_texto = $this::TIPOSREDUCCION[$this->_reduccion];

            $this->_bono = new Bonos(200);
        }
    }


    /**
     * Get the value of _nombre
     */
    public function get_nombre()
    {
        return $this->_nombre;
    }

    /**
     * Set the value of _nombre
     *
     * @return  self
     */
    public function set_nombre($nombre): bool
    {

        if (validaCadena($nombre, 30, "error")) {
            $this->_nombre = $nombre;
            return true;
        }

        return false;
    }

    /**
     * Get the value of _NIF
     */
    public function get_NIF()
    {
        return $this->_NIF;
    }

    /**
     * Set the value of _NIF
     *
     * @return  self
     */
    public function set_NIF($_NIF)
    {
        if (validaNIF($_NIF)) {
            $this->_NIF = $_NIF;
            return true;   
        }

        return false;
    }

    /**
     * Get the value of _reduccion
     */
    public function get_reduccion()
    {
        return $this->_reduccion;
    }

    /**
     * Set the value of _reduccion
     *
     * @return  self
     */
    public function set_reduccion($_reduccion)
    {
        if (validaEntero($_reduccion, 1, 10, 1) ||
                isset($this::TIPOSREDUCCION[$_reduccion])) 
            {
                $this->_reduccion = $_reduccion;
                $this->_reduccion_texto = $this::TIPOSREDUCCION[$this->_reduccion];

                return true;
            }

        return false;
    }

    /**
     * Get the value of _fecha
     */
    public function get_fecha()
    {
        return $this->_fecha;
    }

    /**
     * Set the value of _fecha
     *
     * @return  self
     */
    public function set_fecha($_fecha)
    {
        if (validaFecha($_fecha, date('d/m/y',strtotime("-10 year"))) && 
            fechaAnteriorHoy($_fecha)) 
            {
                $this->_fecha = $_fecha;
                if (mayorEdad($_fecha)) {
                    $this->_mayor_Edad = true;
                } else {
                    $this->_mayor_Edad = false;
                }
    
                return false;
            }

        return $this;
    }

    /**
     * Get the value of _reduccion_texto
     */
    public function get_reduccion_texto()
    {
        return $this->_reduccion_texto;
    }

    /**
     * Get the value of _mayor_Edad
     */
    public function get_mayor_Edad()
    {
        return $this->_mayor_Edad;
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
        return "Beneficiario: " . $this->get_nombre() .
            " con NIF: " . $this->get_NIF() .
            " que nació en " . $this->get_fecha() .
            " que" . ($this->_mayor_Edad == true ? " es " : " no es ") . "mayor de edad" .
            " y tiene reducción: " . $this->_reduccion_texto;
    }

    //--------------------------------------------------------
    //----------------------Métodos---------------------------
    //--------------------------------------------------------

    /**
     * Agrega a los bonos el total de bonos que queramos agregar siendo mínimo uno
     *
     * @param integer $nBonos
     * @param string $bonos
     * @param string $valor
     * @param [type] ...$valorBono
     * @return bool
     */
    public function aniadeBonos(int &$nBonos, string $bonos, string $valor, ...$valorBono): bool
    {

        $contIngresos = 0;
        $realizado = false;

        try
        {
            $this->_bono->$bonos = intval($valor);
            $contIngresos++;
        }
        catch (Exception $e)
        {

        }

        if (count($valorBono) > 1) { //añadimos el resto

            if (count($valorBono) % 2 == 0) {
                $pares = count($valorBono);
            } else {
                $pares = count($valorBono) - 1;
            }

            for ($i = 0; $i < $pares; $i = $i + 2) {
                try
                {
                    $key = $valorBono[$i];
                    $this->_bono->$key = intval($valorBono[$i + 1]);
                    $contIngresos++;
                }
                catch (Exception $e)
                {

                }
            }
        }

        $nBonos = $contIngresos; //actualizamos el número de ingresos realizado

        return ($nBonos>0);
    }

    /**
     * Devuelve un array con el total de importes de los bonos
     *
     * @return array
     */
    public function getImporteBonos(): int
    {

        return $this->_bono->importe;
    }

    /**
     * Devuelve un array copia con las keys y values de los listados de los bonos de la clase
     *
     * @return array
     */
    public function getListaBonos(): array
    {
        $lista = [];

        foreach ($this->_bono as $key => $value) 
        {
            if ($key!="importe")
                $lista[$key] = $value;
        }

        return $lista;
    }

    
}
