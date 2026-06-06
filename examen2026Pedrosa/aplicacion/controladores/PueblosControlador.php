<?php
	 
class PueblosControlador extends CControlador{

    //variables 
    public array $menuizq = [];
    public array $barraUbi = [];
    private array $_MisPueblos = [];
    public int $N_Pueblos = 0;
    public int $N_PueblosUnesco = 0;


    //constructor 
   public function __construct(){
    parent::__construct();
    Sistema::app()->sesion()->crearSesion();

    if (isset($_SESSION["pueblos"])) {
        $this->_MisPueblos = $_SESSION["pueblos"];
    } else {
        $this->iniciarPueblos();
    }

    //variable del controlador
    $this->N_Pueblos = count($this->_MisPueblos);
    // Variable de aplicación 
    Sistema::app()->N_Pueblos = $this->N_Pueblos;
    $this->cuentaUnesco();

    //unset($_SESSION["pueblos"]);

    }


    //funcion para inciiar pueblos dos pueblos de mnaera manual 
   public function iniciarPueblos(){
    $this->_MisPueblos = [];

    $p1 = new Pueblo();
    $p1->setValores([
        "nombre" => "PuebloA",
        "cod_tipo_elemento" => 1,
        "descripcion_tipo" => Listas::listaTipoElemento()[1],
        "elemento" => "ElementoA",
        "reconocido_unesco" => 0,
        "fecha_reconocimiento" => "15/07/1958"
    ]);
    $p1->guardar();

    $p2 = new Pueblo();
    $p2->setValores([
        "nombre" => "PuebloB",
        "cod_tipo_elemento" => 2,
        "descripcion_tipo" => Listas::listaTipoElemento()[2],
        "elemento" => "ElementoB",
        "reconocido_unesco" => 1,
        "fecha_reconocimiento" => "01/01/1975"
    ]);
    $p2->guardar();

    $p3 = new Pueblo();
    $p3->setValores([
        "nombre" => "PuebloC",
        "cod_tipo_elemento" => 1,
        "descripcion_tipo" => Listas::listaTipoElemento()[3],
        "elemento" => "ElementoC",
        "reconocido_unesco" => 0,
        "fecha_reconocimiento" => "01/01/1974"
    ]);
    $p3->guardar();

    $this->_MisPueblos = [1 => $p1, 2 => $p2,3=> $p3];
    $_SESSION["pueblos"] = $this->_MisPueblos;
    }


    //FUNCION PARA CONTAR LOS PUEBLOS DE UNESCO
    public function cuentaUnesco()
    {
    $this->N_PueblosUnesco = 0;
    foreach ($this->_MisPueblos as $p) {
        if ($p->reconocido_unesco == 1) {
            $this->N_PueblosUnesco++;
        }
    }

    }

    //accion Inicial para que sea el controlador principal que hay que modificar el config para que sea el correcto 
     public function accionIndex()
    {
        Sistema::app()->irAPagina(["Pueblos", "puebloinicial"]);
    }

    // Acción desconectar
    public function accionConectar(){
        
    // Generar número aleatorio
        $numeroAleatorio = random_int(0, 1000);

        // 2️Calcular el resto al dividirlo entre el número de pueblos existentes
        // (N_Pueblos es la variable de aplicación que definiste en el constructor)
        $resto = $numeroAleatorio % Sistema::app()->N_Pueblos;

        // Registrar usuario en acceso (sesión)
        // Se usa tu nombre como nick y permisos [2, 4, 6]
        $_SESSION["usuario"] = [
            "nick" => "Natalia",      // tu nombre
            "id" => $resto,           // identificador calculado
            "permisos" => [2, 4, 6]   // permisos requeridos
        ];

        //Redirigir a la página inicial del controlador
        Sistema::app()->irAPagina(["Pueblos", "puebloinicial"]);
    }

    //accion Desconectar
    // Acción DESCONECTAR
    public function accionDesconectar(){
    // 1Comprobar si hay usuario registrado en acceso
    if (!isset($_SESSION["usuario"])) {
        // Si no hay usuario, mostrar error
        Sistema::app()->paginaError(400, "No puedes desconectar: no hay usuario registrado.");
        return;
    }

    // Quitar registro de acceso (eliminar usuario de la sesión)
    unset($_SESSION["usuario"]);

    // Redirigir a la página inicial del controlador
    Sistema::app()->irAPagina(["Pueblos", "puebloinicial"]);
    }


    /**
     * para poder mostrar los pueblos
     */
     public function accionPuebloinicial()
    {
        $this->menuizq = [
			["texto" => "Nuevo", "enlace" => ["Pueblos", "nuevo"]]
		];

		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["pueblos", "puebloinicial"]],
		];

        $pueblos = [];
        $radioSel = 0;
        if (isset($_POST["unesco"])) {
            foreach ($this->_MisPueblos as $p) {
                if ($p->reconocido_unesco == $_POST["unesco"]) {
                    $pueblos[] = $p;
                }
            }

            $radioSel = $_POST["unesco"];
        }



        $datos = ["con unesco", "sin unesco"];
        $this->dibujaVista("puebloinicial", ["datos" => $datos, "pueblos" => $pueblos, "radio" => $radioSel], "Pueblo inicial");
    }


   /**
    * FUNCION PARA NUEVO
    */ 
   public function accionNuevo() {
        $this->menuizq = [
			["texto" => "Inicio", "enlace" => ["Pueblos", "index"]]
		];

		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["pueblos", "index"]],
			["texto" => "Nuevo Pueblo", "enlace" => ["pueblos", "nuevo"]],
		];

        $modelo = new Pueblo();
        $nombre = $modelo->getNombre();

        if(isset($_POST[$nombre])) {

            // comprobar que el nombre tiene al menos 5 caracteres
            if(mb_strlen($_POST[$nombre]["nombre"])<5) {
                $modelo->setError("nombre","Deben ser al menos 5 caracteres");
                
            }
            
            // comprobar que el nombre tiene un -
            if(preg_match_all("/[-]/",$_POST[$nombre]["nombre"])==1){
                $modelo->setError("nombre","El nombre debe tener un guion");
            }

            $_POST[$nombre]["cod_tipo_elemento"] = intval( $_POST[$nombre]["cod_tipo_elemento"]);
            $_POST[$nombre]["reconocido_unesco"] = intval( $_POST[$nombre]["reconocido_unesco"]);
            $_POST[$nombre]["fecha_reconocimiento"] = date("d/m/Y",strtotime($_POST[$nombre]["fecha_reconocimiento"]));

            if( $_POST[$nombre]["cod_tipo_elemento"] == 0){
                $modelo->setError("cod_tipo_elemento", "Debes indicar elemento");
            }
            else
                $_POST[$nombre]["descripcion_tipo"] = Listas::listaTipoElemento()[$_POST[$nombre]["cod_tipo_elemento"]];

            // print_r($_POST[$nombre]);

            $modelo->setValores($_POST[$nombre]);
            if($modelo->validar()) {
                $modelo->guardar();
                $this->_MisPueblos[] = $modelo;
                $_SESSION["pueblos"] = $this->_MisPueblos;
                Sistema::app()->irAPagina(["pueblos","index"]);
            }
        }

        $this->dibujaVista("nuevo",["modelo"=>$modelo],"Nuevo pueblo");
    }

/**
 * FUNCION PARA DESCARGAR
 * @return void
 */
     public function accionDescargar()
{
    // Validar usuario
    if (!isset($_SESSION["usuario"])) {
        Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
        return;
    }

    // Validar permiso (debe ser 6 según el enunciado)
    $permisos = $_SESSION["usuario"]["permisos"] ?? [];
    if (!in_array(6, $permisos)) {
        Sistema::app()->paginaError(403, "No tienes permiso para descargar pueblos.");
        return;
    }

    // Verificar parámetro id
    if (!isset($_GET["id"])) {
        Sistema::app()->paginaError(400, "No se ha indicado ningún pueblo.");
        return;
    }

    $id = $_GET["id"];
    $p = null;

    // Verificar que el pueblo existe en el array de sesión
    foreach ($_SESSION["pueblos"] as $indice => $valor) {
        if ($valor->nombre === $id) {
            $p = $valor;
            break;
        }
    }

    if ($p === null) {
        Sistema::app()->paginaError(404, "El pueblo indicado no existe.");
        return;
    }

    // Poner cabeceras XML
    header("Content-Type: application/xml");
    header("Content-Disposition: attachment; filename=pueblo{$p->nombre}.xml");
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    // Codificar XML con datos del pueblo
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<pueblo>\n";
    echo "   <nombre>{$p->nombre}</nombre>\n";
    echo "   <cod_tipo_elemento>{$p->cod_tipo_elemento}</cod_tipo_elemento>\n";
    echo "   <descripcion_tipo>{$p->descripcion_tipo}</descripcion_tipo>\n";
    echo "   <elemento>{$p->elemento}</elemento>\n";
    echo "   <reconocido_unesco>{$p->reconocido_unesco}</reconocido_unesco>\n";
    echo "   <fecha_reconocimiento>{$p->fecha_reconocimiento}</fecha_reconocimiento>\n";
    echo "</pueblo>\n";

    return;
}




}