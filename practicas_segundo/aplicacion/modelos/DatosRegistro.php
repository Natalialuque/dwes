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

        $hoy = date("Y-m-d");
        $hace18 = date("Y-m-d", strtotime("-18 years"));

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
                "TIPO" => "FECHA",
                "MIN" => "1900-01-01",
                "MAX" => $hoy,
                "DEFECTO" => $hace18
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
    protected function valorDefecto(): void {
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
}
