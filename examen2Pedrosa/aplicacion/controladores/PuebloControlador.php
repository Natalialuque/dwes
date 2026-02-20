<?php

class PuebloControlador extends CControlador
{
	 public array $menuizq = [];
    public array $_Mispueblos = [];
    public int $N_Pueblos = 0;
    public int $N_PueblosUnesco = 0;

    //constructor
    public function __construct()
    {
        parent::__construct();

        Sistema::app()->sesion()->crearSesion();
        if (isset($_SESSION["Pueblos"])) {
            $this->_Mispueblos = $_SESSION["Pueblos"];
        } else {
            $this->inicializarPueblo();
        }

        $this->N_Pueblos = count($this->_Mispueblos);
        $this->calcularPueblosUnesco();
    }

    //Index
    public function accionIndex()
    {
    $this->menuizq = [
        ["texto" => "Inicio", "enlace" => ["pueblo"]],
    ];

        $this->puebloInicial();

    }

    // LOGIN
     public function accionLogin()
     {
         $numeroAleatorio = random_int(0,100);
         if($numeroAleatorio % 6 !== 0){
            Sistema::app()->paginaError(400, "No puedes hacer login");
            return;
         }

         // Registrar usuario
         $_SESSION["usuario"] = [
             "nick" => "pueblo",
            "permisos" => [5]
        ];

        Sistema::app()->irAPagina("index",[],"pueblo");

     }

    // // LOGOUT
     public function accionLogout()
     {
         // Debe haber usuario registrado
         if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "No puedes hacer logout: no hay usuario registrado.");
             return;
         }

         unset($_SESSION["usuario"]);

       // $this->dibujaVista("logout", [], "Logout correcto");
         Sistema::app()->irAPagina("index",[],"pueblo");
    }

	// INICIALIZAR PUBLO
    private function inicializarPueblo()
    {
    
        $this->_Mispueblos = [];

        // Lista completa de pueblo
       // $lista = Listas::ListaTiposElemento();

        for ($i = 1; $i <= 2; $i++) {

            $p = new Pueblos();
            $codPueblo = $i +1;

            
            $p->setValores([
                "nombre" => "pueblo",
                "cod_tipo" => $codPueblo ,
                "descripcion_tipo" => "no indicado",
                "elemento" => "Ele$i",
                "reconocido_unesco" => 0,
                "fecha_reconocimiento" =>  date("Y/m/d")
            ]);

            $p->guardar();

            $this->_Mispueblos[$i] = $p;
        }

        $_SESSION["Pueblos"] = $this->_Mispueblos;

    }

    private function calcularPueblosUnesco()
    {
       if($this->N_PueblosUnesco = 0){
            $this->N_PueblosUnesco++;
       }

    }

    /**
     * PUEBLO INICIAl
     */
     public function puebloInicial()
    {
    // menú lateral
    $this->menuizq = [
        ["texto" => "Inicio",
         "enlace" => ["pueblo"]]
    
    ];
   
    // mostrar vista
    $this->dibujaVista(
        "puebloInicial",
        [
           
        ],
        "Ver pueblo"
    );
    }


    /**
     * ACCION NUEVO
     */
    public function accionNueva(){


         $modelo = new Pueblos();

         $this->dibujaVista(
            "nueva",
             [

             ],
             "nueva pueblo"
         );
    }


    /**
    * accion DESCARGA
    */
    public function accionDescargar()
    {
        // Comprobar usuario
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
            return;
        }

        // Comprobar permiso 5
        if (!in_array(5, $_SESSION["usuario"]["permisos"])) {
            Sistema::app()->paginaError(403, "No tienes permiso para descargar pueblos.");
            return;
        }

        // Comprobar que llega un código de pueblo
        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(400, "No se ha indicado ningun pueblo.");
            return;
        }

        $id = intval($_GET["id"]);

        // Obtener pueblo
        $p = "";

        foreach($_SESSION["Pueblos"] as $valor) {
            if($valor->cod_tipo == $id) {
                $p=$valor;
            }
        }

        // Comprobar que el pueblo existe
        if ($p==="") {
            Sistema::app()->paginaError(404, "La pueblo indicada no existe.");
            return;
        }

        // CABECERAS DE DESCARGA DIRECTA
        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=pueblo{$p->cod_tipo}.xml");
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        // GENERAR XML DIRECTAMENTE
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<pueblo>\n";
        echo "    <nombre>{$p->nombre}</nombre>\n";
        echo "    <cod_tipo>{$p->cod_tipo}</cod_tipo>\n";
        echo "    <descripcion_tipo>{$p->descripcion_tipo}</descripcion_tipo>\n";
        echo "    <elemento>{$p->elemento}</elemento>\n";
        echo "    <reconocido_unesco>{$p->reconocido_unesco}</reconocido_unesco>\n";
        echo "    <fecha_reconocimiento>{$p->jugadores}</fecha_reconocimiento>\n";
        echo "</pueblo>";

        return; 
    }

}