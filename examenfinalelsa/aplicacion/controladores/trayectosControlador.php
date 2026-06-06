<?php

class trayectosControlador extends CControlador
{

    public array $paradasTray = [];
    public int $N_ParadasOrigen = 0;

    // Constructor: se inicializan las partidas y se configuran las variables
    public function __construct()
    {
        parent::__construct();


        // Actualizamos el número total de partidas.
        Sistema::app()->N_Paradas = count($this->paradasTray);

        $resultado = $this->crearParadas();
        if (!$resultado) {
            $this->paradasTray = [];
        } else {
            $this->paradasTray = $resultado;
        }

        $this->N_ParadasOrigen = $this->contarParadas();

        $this->accionDefecto = "origen";
    }





    public function accionConectar()
    {
        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->Acceso()->registrarUsuario("Elsa", "Elsa", [mt_rand(2, 6)]);
            Sistema::app()->irAPagina(["trayectos", "origen"]);
        } else {
            Sistema::app()->paginaError(404, "Ya hay un usuario registrado");
        }
    }
    public function accionDesconectar()
    {
        if (Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->Acceso()->quitarRegistroUsuario();
            Sistema::app()->irAPagina(["trayectos", "origen"]);
        } else {
            //TODO vista error
        }
    }

    public function accionOrigen()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paradas = [];
            if (isset($_POST["trayectos"])) {

                $cod_trayecto =  intval($_POST["trayectos"]);

                foreach ($this->paradasTray as $key => $value) {
                    if ($key == $cod_trayecto) {
                        $paradas[] = $value;
                    }
                }
                $this->dibujaVista("origen", ["paradas" => $paradas, "cod_trayecto" => $cod_trayecto], "Origen");
                return;
            }
        }
        $this->dibujaVista("origen", [], "Origen");
    }


    public function accionNueva()
    {
        $modelo = new Parada();
        $nombreModelo = $modelo->getNombre();
        if (isset($_POST[$nombreModelo])) {
            $cod = $_POST["cod_trayecto"];
            $estacion = $_POST[$nombreModelo]["estacion"];
            $poblacion = $_POST[$nombreModelo]["poblacion"];

            $modelo->setValores(["cod_trayecto" => $cod, "estacion" => $estacion, "poblacion" => $poblacion]);
            if (!$modelo->validar()) {
                $this->dibujaVista("nueva", ["modelo" => $modelo], "Nueva Parada");
                return;
            }
            $parada_nueva[$modelo->cod_trayecto] = $modelo->getTodosAtributos();
            $_SESSION["parada"][] = $parada_nueva;
            Sistema::app()->irAPagina(["trayectos", "origen"]);
            return;
        }

        $this->dibujaVista("nueva", ["modelo" => $modelo], "Nueva Parada");
    }

    private function crearParadas(): array|bool
    {


        $paradas = [];

        $datos1 = [
            "cod_trayecto" => 1,
            "estacion" => "Antequera Santa Ana",
            "poblacion" => "Antequera",
        ];
        $datos2 = [
            "cod_trayecto" => 1,
            "estacion" => "Antequera Ciudad",
            "poblacion" => "Antequera",
        ];


        $modelo = new Parada();

        $modelo->setValores($datos1);

        if (!$modelo->validar()) {
            return false;
        }

        $paradas[$datos1['cod_trayecto']][] = $modelo->getTodosAtributos();

        $modelo->setValores($datos2);
        if (!$modelo->validar()) {
            return false;
        }

        $paradas[$datos2['cod_trayecto']][] = $modelo->getTodosAtributos();

        if (isset($_SESSION["parada"])) {
            foreach ($_SESSION["parada"] as  $value) {
                foreach ($value as $key => $valor) {
                    $paradas[$key][] = $valor;
                }
            }
        }
        return $paradas;
    }




    public function accionDescargar()
    {

        if (!Sistema::app()->Acceso()->hayUsuario()) {
            Sistema::app()->paginaError(404, "No tienes permiso para esta página");
            return;
        }

        $id = $_GET["cod_trayecto"] ?? null;
        if ($id === null) {
            Sistema::app()->paginaError(404, "No se ha recibido el código");
            return;
        }

        if (!array_key_exists($id, $this->paradasTray)) {
            Sistema::app()->paginaError(404, "No se encuentra El trayecto");
            return;
        }

        $parada  = $this->paradasTray[$id];

        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=parada_{$id}.xml");

        $contenido = "
<trayecto>
    <cod_trayecto>$parada->cod_trayecto</cod_trayecto>
    <nombreTrayecto>$parada->nombreTrayecto</nombreTrayecto>
    <estacion>$parada->estacion)</estacion>
    <poblacion>$parada->poblacion)</poblacion>
    <es_origen>$parada->es_origen)</es_origen>
</trayecto>
";

        echo $contenido;

        exit;
    }

    public function contarParadas(): int
    {
        $contador = 0;
        foreach ($this->paradasTray as $key => $value) {

            foreach ($value as $key => $valor) {
                if ($valor["es_origen"] == 1) {
                    $contador++;
                }
            }
        }
        return $contador;
    }
}
