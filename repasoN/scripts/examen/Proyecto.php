<?php
include_once(dirname(__FILE__) . "/../../librerias/validacion.php");

class Proyecto {

//constante public 
const TIPOPROYECTO = [
        10 => "Solo software",
        20 => "Solo hardware",
        30 => "Software/Hardware",
];

//Propiedades 
//por entrada
protected string $_nombre;
protected string $_empresa;
protected string $_fecha_inicio="";
protected string $_fecha_fin="";
protected int $_tipo=10;


//por calculado
protected int $_duracion;
protected string $_tipo_descripcion;

//soporte para Otras
private Otras $_otras;

//constructor 
public function __construct(string $nombre, string $empresa, string $fecha_inicio="", string $fecha_fin="", int $tipo=10){

    //validar nombre
     if ($this->setNombre($nombre) != 0) {

            throw new Exception("Nombre es obligatorio y tiene que tener 40 caracteres maximo");
        } else $this->_nombre;

    //validar empresa
      if ($this->setEmpresa($empresa) != 0) {

            throw new Exception("Empresa es obligatoria y tiene que tener 35 caracteres maximo");
        } else $this->_empresa;

    //validar tipo con self porque viene de TIPOPROYECTO
        if ($this->setTipo($tipo)!=0){
            $this->_tipo = 10;
        } else $this->_tipo = 10;

    //validar tipo descripcion con self porque viene de TIPOPROYECTO
        $this->_tipo_descripcion = self::TIPOPROYECTO[$this->_tipo] ?? "Desconocido";
    
    $fechaHoy = new DateTime();

        if ($this->setFechaInicio($fecha_inicio) != 0) {
            $this->_fecha_inicio = $fechaHoy->format("d/m/Y");
        }

        if ($this->setFechaFin($fecha_fin) != 0) {
            $this->_fecha_fin = date('d/m/Y', strtotime("+6 month"));
        }

        $fechaI = DateTime::createFromFormat("d/m/Y", $this->_fecha_inicio);
        $fechaF = DateTime::createFromFormat("d/m/Y", $this->_fecha_fin);

        if (!$fechaI || !$fechaF) {
            throw new Exception("Fechas inválidas para calcular duración");
        }

        $interval = $fechaI->diff($fechaF);
        $this->_duracion = intval($interval->days);

     $this->_otras = new Otras;

}

//metodos get de todas las propiedades 
public function getNombre(){
    return $this->_nombre;
}
public function getEmpresa(){
    return $this->_empresa;
}
public function getFechaInicio(){
    return $this->_fecha_inicio;
}
public function getFechaFin(){
    return $this->_fecha_fin;
}
public function getTipo(){
    return $this->_tipo;
}
public function getDuracion(){
    return $this->_duracion;
}
public function getTipoDescripcion(){
    return $this->_tipo_descripcion;
}

//metodos set para las propiedades no calculables 
public function setNombre($nombre): int{
    if(!validaCadena($nombre,40,"")){
        return -2;
    }
     if(trim($nombre)==""){
        return -1;
    }
    $this ->_nombre=$nombre;
    return 0;
}
public function setEmpresa($empresa):int{
    if(!validaCadena($empresa,35,"")){
        return -2;
    }
     if(trim($empresa)==""){
        return -1;
    }
    $this-> _empresa=$empresa;
    return 0;
}
public function setFechaInicio($fecha):int
   {
        $fechaHoy = new Datetime();

        if (!validaFecha($fecha, $fechaHoy->format("d/m/Y")))
            return -1;
        if (!ComprobarFecha($fecha)) return -2;

        $this->_fecha_inicio = $fecha;
        return 0;
    }


public function setFechaFin($fecha): int
    {

        if (!validaFecha($fecha, date('d/m/Y', strtotime("+6 month")))) return -1;
        if (!ComprobarFecha($this->_fecha_inicio, $fecha)) return -2;
        $this->_fecha_fin = $fecha;
        return 0;
    }

public function setTipo($tipo):int{
    if (!validaEntero($tipo, 10, 30, 10))
            return -1;
        if (!validaRango($tipo, $this::TIPOPROYECTO, 2)) return -2;
        else $this->_tipo = $tipo;
        return 0;
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

    //toString
    public function __toString()
        {
             return "Proyecto " . $this->_nombre .
                " para " . $this->_empresa .
                " que durará " . $this->_duracion .
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
    public function aniadeOtras(string $propiedad, mixed $valor, int &$n_prop, ...$valoresPropiedades): bool
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
                $this->_otras->$key = $valoresPropiedades[$i + 1];
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

?>