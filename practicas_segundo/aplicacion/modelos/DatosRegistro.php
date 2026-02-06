<?php
class DatosRegistro extends CActiveRecord {

    /* 
     *   NOMBRE DEL MODELO
     */
    protected function fijarNombre(): string {
        return 'datosRegistro';
    }

    /* 
    *    ATRIBUTOS 
    */
    protected function fijarAtributos(): array {
        return array(
            "nick",
            "nif",
            "fecha_nacimiento",
            "provincia",
            "estado",
            "contrasenia",
            "confirmar_contrasenia"
        );
    }

    /* 
    *   DESCRIPCIONES (para formularios)
    */
    protected function fijarDescripciones(): array {
        return array(
            "nick" => "Nick",
            "nif" => "NIF",
            "fecha_nacimiento" => "Fecha de nacimiento",
            "provincia" => "Provincia",
            "estado" => "Estado",
            "contrasenia" => "Contraseña",
            "confirmar_contrasenia" => "Confirmar contraseña"
        );
    }

    /* 
     *   RESTRICCIONES
     */
    protected function fijarRestricciones(): array {

        return array(

            // Obligatorios
            array(
                "ATRI" => "nick,nif,contrasenia,confirmar_contrasenia",
                "TIPO" => "REQUERIDO"
            ),

            // Nick
            array(
                "ATRI" => "nick",
                "TIPO" => "CADENA",
                "TAMANIO" => 40
            ),

            // NIF
            array(
                "ATRI" => "nif",
                "TIPO" => "CADENA",
                "TAMANIO" => 10
            ),

            // Fecha nacimiento
            array(
                
                "ATRI" => "fecha_nacimiento",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaFechaAlta"
            ),

            // Provincia
            array(
                "ATRI" => "provincia",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "DEFECTO" => "MALAGA"
            ),

            // Estado
            array(
                "ATRI" => "estado",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX" => 4,
                "DEFECTO" => 0
            ),

            // Contraseñas iguales
            array(
                "ATRI" => "contrasenia",
                "TIPO" => "CADENA",
                "TAMANIO" => 30
            ),
            array(
                "ATRI" => "confirmar_contrasenia",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarContrasenias"
            )
        );
    }

    /* 
    *  VALIDACIÓN CONTRASEÑAS
    */
    protected function validarContrasenias() {
        if ($this->contrasenia === "" || $this->confirmar_contrasenia === "") {
            $this->setError("confirmar_contrasenia", "Las contraseñas no pueden estar vacías");
            return;
        }

        if ($this->contrasenia !== $this->confirmar_contrasenia) {
            $this->setError("confirmar_contrasenia", "Las contraseñas deben coincidir");
        }
    }

    /* 
    *  VALORES POR DEFECTO AL CREAR
    */
    protected function afterCreate(): void {
    $this->provincia = "MALAGA";
    $this->estado = 0;
    $this->fecha_nacimiento = date("Y-m-d", strtotime("-18 years"));
}


    /* 
     *   MÉTODO ESTÁTICO dameEstados()
    */
    public static function dameEstados($cod_estado = null) {

        $estados = array(
            0 => "No se sabe",
            1 => "Estudiando",
            2 => "Trabajando",
            3 => "En paro",
            4 => "Jubilado"
        );

        if ($cod_estado === null) {
            return $estados;
        }

        return $estados[$cod_estado] ?? false;
    }
// VALIDACIÓN DE FECHA CORRECTA 
protected function validaFechaAlta() { 
    // 1. Convertir dd/mm/yyyy → yyyy-mm-dd si hace falta 
    if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $this->fecha_nacimiento)) {
         list($d, $m, $y) = explode('/', $this->fecha_nacimiento);
          $this->fecha_nacimiento = "$y-$m-$d"; 
        } 
        
        // 2. Intentar crear fecha ISO
         $fecha = DateTime::createFromFormat('Y-m-d', $this->fecha_nacimiento); 
         if (!$fecha) { 
            $this->setError("fecha_nacimiento", "Formato de fecha no válido");
             return; 
            } 
            
            $min = new DateTime("1900-01-01"); 
            $max = new DateTime(); 
            // hoy 
            if ($fecha < $min) {
                 $this->setError("fecha_nacimiento", "La fecha de nacimiento debe ser superior a 01/01/1900"); 
                
            } 
            if ($fecha > $max) {
                 $this->setError("fecha_nacimiento", "La fecha de nacimiento debe ser inferior a la del día de hoy"); 
                } 
    }
}