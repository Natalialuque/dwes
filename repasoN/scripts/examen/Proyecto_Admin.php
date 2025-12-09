<?php
//clase que hereda de Proyecto
final class Proyecto_Admin extends Proyecto {

    //propiedades 
    protected string $_expediente = "2024/00001";

    //constructor 
    public function __construct(
        string $nombre,
        string $empresa,
        string $fecha_inicio = "",
        string $fecha_fin = "",
        int $tipo = 10,
        string $exp = "2024/00001"
    ) {
        parent::__construct($nombre, $empresa, $fecha_inicio, $fecha_fin, $tipo); // llamamos a la clase padre

        if ($this->setExpediente($exp) != 0) {
            $this->_expediente = "2024/00001";
        }

        // Ajustar fecha fin +20 días solo si es válida
        $fechaFin = DateTime::createFromFormat("d/m/Y", $this->_fecha_fin);
        if ($fechaFin instanceof DateTime) {
            $fechaFin->modify("+20 days");
            $this->setFechaFin($fechaFin->format("d/m/Y"));
        }
    }

    //get y set de expediente 
    public function getExpediente() {
        return $this->_expediente;
    }

    public function setExpediente($exp) {
        $reg = "/^[0-9]{4}\/[0-9]{5}$/";
        if (!validaCadena($exp, 10, "2024/00001")) {
            return -2;
        }
        if (!validaExpresion($exp, $reg, "2024/00001")) return -1;
        $this->_expediente = $exp;
        return 0;
    }

    //redefinir el toString 
    public function __toString() {
        return parent::__toString() . " con expediente " . $this->getExpediente();
    }
}
?>
