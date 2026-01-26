<?php
class Productos extends CActiveRecord {

    /* 
     *   NOMBRE DEL MODELO
     */
    protected function fijarNombre(): string {
        return "productos";
    }

    /* 
     *   ATRIBUTOS 
     */
    protected function fijarAtributos(): array {
        return [
            "cod_producto",
            "nombre",
            "cod_categoria",
            "fabricante",
            "fecha_alta",
            "unidades",
            "precio_base",
            "iva",
            "precio_iva",
            "precio_venta",
            "foto",
            "borrado",
            "descripcion_categoria" // viene de la vista cons_productos
        ];
    }

    /* 
     *   DESCRIPCIONES (para formularios)
     */
    protected function fijarDescripciones(): array {
        return [
            "cod_producto" => "Código",
            "nombre" => "Nombre",
            "cod_categoria" => "Categoría",
            "fabricante" => "Fabricante",
            "fecha_alta" => "Fecha de alta",
            "unidades" => "Unidades",
            "precio_base" => "Precio base",
            "iva" => "IVA (%)",
            "precio_iva" => "Precio IVA",
            "precio_venta" => "Precio venta",
            "foto" => "Foto",
            "borrado" => "Borrado",
            "descripcion_categoria" => "Categoría"
        ];
    }

    /* 
     *   RESTRICCIONES
     */
    protected function fijarRestricciones(): array {

        return [

            // Código producto
            [
                "ATRI" => "cod_producto", 
                "TIPO" => "ENTERO", 
                "REQUERIDO" => true
            ],

            // Nombre
            [
                "ATRI" => "nombre", 
                "TIPO" => "CADENA", 
                "TAMANIO" => 30, 
                "REQUERIDO" => true
            ],

            // Categoría válida
            [
                "ATRI" => "cod_categoria", 
                "TIPO" => "ENTERO", 
                "REQUERIDO" => true
            ],
            [
                "ATRI" => "cod_categoria",
                 "TIPO" => "FUNCION", 
                 "FUNCION" => "validarCategoria"
            ],

            // Fabricante
            [
                "ATRI" => "fabricante", 
                "TIPO" => "CADENA", 
                "TAMANIO" => 30
            ],

            // Fecha alta
            [
                "ATRI" => "fecha_alta", 
                "TIPO" => "FECHA"
            ],

            // Unidades (pueden ser negativas)
            [
                "ATRI" => "unidades", 
                "TIPO" => "ENTERO"
            ],

            // Precio base
            [
                "ATRI" => "precio_base", 
                "TIPO" => "REAL", 
                "MIN" => 0
            ],

            // IVA
            [
                "ATRI" => "iva", 
                "TIPO" => "ENTERO"],
            [
                "ATRI" => "iva", 
                "TIPO" => "FUNCION", 
                "FUNCION" => "validarIVA"
            ],

            // Foto
            [
                "ATRI" => "foto",
                 "TIPO" => "CADENA", 
                 "TAMANIO" => 40
            ],

            // Borrado (0 o 1)
            [
                "ATRI" => "borrado", 
                "TIPO" => "ENTERO", 
                "MIN" => 0,
                "MAX" => 1
            ]
        ];
    }

    /* 
     *   VALORES POR DEFECTO
     */
    protected function afterCreate(): void {
        $this->fabricante = "";
        $this->fecha_alta = date("Y-m-d");
        $this->unidades = 0;
        $this->precio_base = 0;
        $this->iva = 21;
        $this->precio_iva = 0;
        $this->precio_venta = 0;
        $this->foto = "base.png";
        $this->borrado = 0;
    }

    /* 
     *   VALIDAR CATEGORÍA
     */
    protected function validarCategoria() {
        if (!Categorias::dameCategorias($this->cod_categoria)) {
            $this->setError("cod_categoria", "La categoría no existe.");
        }
    }

    /* 
     *   VALIDAR IVA
     */
    protected function validarIVA() {
        $validos = [4, 10, 21];
        if (!in_array($this->iva, $validos)) {
            $this->setError("iva", "El IVA debe ser 4, 10 o 21.");
        }
    }

}
