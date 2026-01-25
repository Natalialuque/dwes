<?php
class Login extends CActiveRecord {

    /* 
     *   NOMBRE DEL MODELO
     */
    protected function fijarNombre(): string {
        return "login";
    }

    /* 
    *    ATRIBUTOS 
     */
    protected function fijarAtributos(): array {
        return ["nick", "contrasenia"];
    }

      /* 
     *   DESCRIPCIONES (para formularios)
     */
    protected function fijarDescripciones(): array {
        return [
            "nick" => "Nick",
            "contrasenia" => "Contraseña"
        ];
    }

    /* 
     *   RESTRICCIONES
     */
    protected function fijarRestricciones(): array {
        return [
            // Obligatorios
            ["ATRI" => "nick,contrasenia", "TIPO" => "REQUERIDO"],

            // Nick
            ["ATRI" => "nick", "TIPO" => "CADENA", "TAMANIO" => 20],

            // Contraseña
            ["ATRI" => "contrasenia", "TIPO" => "CADENA", "TAMANIO" => 20],

            // Validación personalizada
            ["ATRI" => "contrasenia", "TIPO" => "FUNCION", "FUNCION" => "validarContrasenia"]
        ];
    }

    /**
     * VALIDAR CONTRASEÑA
     *
     * @return void
     */
    protected function validarContrasenia() {
        $correcta = "c-" . $this->nick;

        if ($this->contrasenia !== $correcta) {
            $this->setError("contrasenia", "La contraseña no es correcta. Debe ser: c-".$this->nick);
        }
    }

    /**
     * VALORES DEFECTO
     */

    protected function valorDefecto(): void {
        $this->nick = "";
        $this->contrasenia = "";
    }
}
