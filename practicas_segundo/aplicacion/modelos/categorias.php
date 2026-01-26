<?php
class Categorias extends CActiveRecord {

    /* 
     *   NOMBRE DEL MODELO
     */
    protected function fijarNombre(): string {
        return "categorias";
    }

    /* 
     *   ATRIBUTOS 
     */
    protected function fijarAtributos(): array {
        return [
            "cod_categoria",
            "descripcion"
        ];
    }

    /* 
     *   DESCRIPCIONES (para formularios)
     */
    protected function fijarDescripciones(): array {
        return [
            "cod_categoria" => "Código de categoría",
            "descripcion"   => "Descripción"
        ];
    }

    /* 
     *   RESTRICCIONES
     */
    protected function fijarRestricciones(): array {
        return [

            // Obligatorios
            [
                "ATRI" => "cod_categoria,descripcion",
                "TIPO" => "REQUERIDO"
            ],

            // Código categoría
            [
                "ATRI" => "cod_categoria",
                "TIPO" => "ENTERO"
            ],

            // Descripción
            [
                "ATRI" => "descripcion",
                "TIPO" => "CADENA",
                "TAMANIO" => 40
            ]
        ];
    }

    /* 
     *   VALORES POR DEFECTO
     */
    protected function afterCreate(): void {
        $this->cod_categoria = 0;
        $this->descripcion   = "";
    }

    /* 
     *   MÉTODO ESTÁTICO dameCategorias()
     *   Igual que dameEstados, pero leyendo de la BD
     */
    public static function dameCategorias($codigo = null) {

        // Obtener todas las categorías de la BD
        $categorias = Sistema::app()->BD()->crearConsulta(
            "SELECT cod_categoria, descripcion FROM categorias"
        )->filas();

        // Convertir a array asociativo: cod => descripcion
        $lista = [];
        foreach ($categorias as $fila) {
            $lista[$fila["cod_categoria"]] = $fila["descripcion"];
        }

        // Si no se pasa código → devolver todas
        if ($codigo === null) {
            return $lista;
        }

        // Si se pasa código → devolver descripción o false
        return $lista[$codigo] ?? false;
    }
}
