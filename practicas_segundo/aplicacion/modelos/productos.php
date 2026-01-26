<?php
class Productos extends CActiveRecord {

    /* 
     *   NOMBRE DEL MODELO
     */
    protected function fijarNombre(): string {
        return "productos";
    }

    /**
     * FIJAR TABLA
     */
      protected function fijarTabla(): string
    {
        return 'cons_productos';
    }

    /* 
     *   ATRIBUTOS 
     */
    protected function fijarAtributos(): array {
        return [
            "cod_producto",
            "cod_categoria",
            "descripcion_categoria",
            "nombre",
            "fabricante",
            "fecha_alta",
            "unidades",
            "precio_base",
            "iva",
            "precio_iva",
            "precio_venta",
            "foto",
            "borrado" // viene de la vista cons_productos
        ];
    }

    /* 
     *   DESCRIPCIONES (para formularios)
     */
    protected function fijarDescripciones(): array {
        return [
            "cod_producto" => "Código",
            "cod_categoria" => "Categoría",
            "descripcion_categoria" => "Categoría",
             "nombre" => "Nombre",
            "fabricante" => "Fabricante",
            "fecha_alta" => "Fecha de alta",
            "unidades" => "Unidades",
            "precio_base" => "Precio base",
            "iva" => "IVA (%)",
            "precio_iva" => "Precio IVA",
            "precio_venta" => "Precio venta",
            "foto" => "Foto",
            "borrado" => "Borrado",
            
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

            // Nombre
            [
                "ATRI" => "nombre", 
                "TIPO" => "CADENA", 
                "TAMANIO" => 30, 
                "REQUERIDO" => true
            ],

            // Fabricante
            [
                "ATRI" => "fabricante", 
                "TIPO" => "CADENA", 
                "TAMANIO" => 30,
                "DEFECTO" => ""

            ],

            // Fecha alta
            [
                "ATRI" => "fecha_alta", 
                "TIPO" => "FECHA",
                 "DEFECTO" => date("Y-m-d")

            ],

            // Unidades (pueden ser negativas)
            [
                "ATRI" => "unidades", 
                "TIPO" => "ENTERO",
                "DEFECTO" => 0

            ],

            // Precio base
            [
                "ATRI" => "precio_base", 
                "TIPO" => "REAL", 
                "DEFECTO" => 0,
                "MIN" => 0
            ],

            // IVA
             [
                "ATRI" => "iva",
                "TIPO" => "REAL",
                "DEFECTO" => 21.0
            ],
            [
                "ATRI" => "iva",
                "TIPO" => "RANGO",
                "RANGO" => [4,10,21]
            ],
               //Precio iva
            [
                "ATRI" => "precio_iva",
                "TIPO" => "REAL"
            ],
            //Preicio venta
            [
                "ATRI" => "precio_venta",
                "TIPO" => "REAL"
            ],

            // Foto
            [
                "ATRI" => "foto",
                 "TIPO" => "CADENA", 
                 "TAMANIO" => 40,
                "DEFECTO" => "base.png"

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
      $precio = ($this->precio_base === "" ? 0 : floatval($this->precio_base));
        $iva    = ($this->iva === "" ? 0 : floatval($this->iva));

        $this->precio_iva   = $precio * ($iva / 100);
        $this->precio_venta = $precio + $this->precio_iva;
    }

    /* 
     *   VALIDAR CATEGORÍA
     */
    protected function validarCategoria() {
        if (!Categorias::dameCategorias($this->cod_categoria)) {
            $this->setError("cod_categoria", "La categoría no existe.");
        }
    }


}
