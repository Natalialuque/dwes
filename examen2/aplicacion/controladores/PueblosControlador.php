<?php

class PueblosControlador extends CControlador
{
    public array $menuizq = [];
    public array $barraUbi = [];
    private array $_MisPueblos = [];
    public int $N_Pueblos = 0;
    public int $N_PueblosUnesco = 0;

    public function __construct()
    {
        parent::__construct();
        Sistema::app()->sesion()->crearSesion();

        if (isset($_SESSION["pueblos"])) {
            $this->_MisPueblos = $_SESSION["pueblos"];
        } else {
            $this->iniciarPueblos();
        }

        $this->N_Pueblos = count($this->_MisPueblos);
        $this->cuentaUnesco();
    }

    public function accionConectar()
    {
        $num = rand(1, 1000);
        $resto = $num % 6;
        if ($resto % 2 == 0) {
            $_SESSION["usuario"] = [
                "nombre" => "pueblo",
                "permiso" => 5
            ];
        }

        Sistema::app()->irAPagina(["Pueblos", "Puebloinicial"]);
    }
    public function accionDesconectar()
    {
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "No puedes hacer logout: no hay usuario registrado.");
            return;
        }

        unset($_SESSION["usuario"]);
        Sistema::app()->irAPagina(["Pueblos", "Puebloinicial"]);
    }

    public function accionIndex()
    {
        Sistema::app()->irAPagina(["Pueblos", "puebloinicial"]);
    }

    public function accionPuebloinicial()
    {
        $this->menuizq = [
			["texto" => "Nuevo", "enlace" => ["Pueblos", "nuevo"]]
		];

		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["pueblos", "index"]],
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

    public function accionNuevo() {
        $this->menuizq = [
			["texto" => "Inicio", "enlace" => ["Pueblos", "index"]]
		];

		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["pueblos", "index"]],
			["texto" => "Nuevo Pueblo", "enlace" => ["pueblos", "nuevo"]],
		];

        $modelo = new Pueblos();
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
                $_POST[$nombre]["descripcion_tipo"] = Listas::listaTipoElementos()[$_POST[$nombre]["cod_tipo_elemento"]];

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

   public function accionDescargar()
    {
        // Comprobar usuario
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
            return;
        }

        // Comprobar permiso 5

        $num = $_SESSION["usuario"]["permiso"];
        if ($num!=5) {
            Sistema::app()->paginaError(403, "No tienes permiso para descargar Pueblos.");
            return;
        }

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(400, "No se ha indicado ningun pueblo.");
            return;
        }

        $nombre =$_GET["id"];

        $p = "";

		foreach($_SESSION["pueblos"] as $valor) {
			if($valor->nombre == $nombre) {
				$p=$valor;
			}
		}

		// Comprobar que el pueblo existe
        if ($p==="") {
            Sistema::app()->paginaError(404, "El pueblo indicada no existe.");
            return;
        }

        
        // CABECERAS DE DESCARGA DIRECTA
        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=pueblo{$p->nombre}.xml");
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        // GENERAR XML DIRECTAMENTE
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<pueblo>";
        echo "  <nombre>{$p->nombre}</nombre>";
        echo "  <cod_tipo_elemento>{$p->cod_tipo_elemento}</cod_tipo_elemento>";
        echo "  <descripcion_tipo>{$p->descripcion_tipo}</descripcion_tipo>";
        echo "  <elemento>{$p->elemento}</elemento>";
        echo "  <reconocido_unesco>{$p->reconocido_unesco}</reconocido_unesco>";
        echo "  <fecha_reconocimiento>{$p->fecha_reconocimiento}</fecha_reconocimiento>";
        echo "</pueblo>";

        return;
        
    }

    public function cuentaUnesco()
    {
        foreach ($this->_MisPueblos as $p) {
            if ($p->reconocido_unesco == 1) {
                $this->N_PueblosUnesco++;
            }
        }
    }

    public function iniciarPueblos()
    {
        $this->_MisPueblos = [];
        for ($i = 1; $i <= 2; $i++) {
            $p = new Pueblos();
            $p->setValores([
                "nombre" => "Pueblo$i",
                "cod_tipo_elemento" => $i,
                "descripcion_tipo" => Listas::listaTipoElementos()[$i],
                "elemento" => "elemento $i",
                "reconocido_unesco" => $i - 1,
                "fecha_reconocimiento" => date("d/m/Y", strtotime("-" . ($i - 1) . " day"))
            ]);

            $p->guardar();
            $this->_MisPueblos[$i] = $p;
        }

        $_SESSION["pueblos"] = $this->_MisPueblos;
    }
}
