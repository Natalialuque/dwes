<?php
class ParadasControlador extends CControlador
{
    public array $menuizq = [];
    public array $barraUbi = [];
    private array $ParadasTray = [];
    public int $N_Paradas = 0;
    public int $N_ParadasOrigen = 0;

    public function __construct()
    {
        parent::__construct();
        $this->accionDefecto = "ver";
        Sistema::app()->sesion()->crearSesion();

        if (isset($_SESSION["ParadasTray"])) {
            $this->ParadasTray = $_SESSION["ParadasTray"];
        } else {
            $this->iniciarParadas();
        }

        $this->actualizaContadores();
    }

    private function iniciarParadas(): void
    {
        $p1 = new Parada();
        $p1->setValores([
            "cod_trayecto" => 3,
            "estacion" => "Estacion Centro",
            "poblacion" => "Malaga",
            "es_origen" => 1,
        ]);
        $p1->validar();

        $p2 = new Parada();
        $p2->setValores([
            "cod_trayecto" => 5,
            "estacion" => "Estacion Norte",
            "poblacion" => "Granada",
            "es_origen" => 0,
        ]);
        $p2->validar();

        $this->ParadasTray = [
            $p1->cod_trayecto => $p1,
            $p2->cod_trayecto => $p2,
        ];
        $_SESSION["ParadasTray"] = $this->ParadasTray;
    }

    private function actualizaContadores(): void
    {
        $this->N_Paradas = count($this->ParadasTray);
        $this->N_ParadasOrigen = 0;

        foreach ($this->ParadasTray as $parada) {
            if (intval($parada->es_origen) === 1) {
                $this->N_ParadasOrigen++;
            }
        }

        Sistema::app()->N_Paradas = $this->N_Paradas;
    }

    public function accionIndex(): void
    {
        Sistema::app()->irAPagina(["ParadasTray", "ver"]);
    }

    public function accionLogin(): void
    {
        if ($this->N_Paradas < 1) {
            Sistema::app()->paginaError(400, "No se puede iniciar sesion si no hay paradas registradas.");
            return;
        }

        $_SESSION["usuario"] = [
            "nick" => "Natalia",
            "permisos" => [2, 4, 6],
        ];

        Sistema::app()->irAPagina(["ParadasTray", "ver"]);
    }

    public function accionLogout(): void
    {
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "No hay usuario registrado.");
            return;
        }

        if ($this->N_Paradas < 2) {
            Sistema::app()->paginaError(400, "No se puede cerrar sesion si hay menos de dos paradas.");
            return;
        }

        unset($_SESSION["usuario"]);
        Sistema::app()->irAPagina(["ParadasTray", "ver"]);
    }



    public function accionVer(): void
    {
        $this->menuizq = [
            ["texto" => "Nueva parada", "enlace" => ["ParadasTray", "nueva"]],
        ];

        $this->barraUbi = [
            ["texto" => "Paradas", "enlace" => ["ParadasTray", "ver"]],
        ];

        $estaciones = $this->listaEstaciones();
        $estacionSeleccionada = $_POST["estacion"] ?? "";
        $paradas = [];

        if ($estacionSeleccionada !== "") {
            foreach ($this->ParadasTray as $parada) {
                if ($parada->estacion === $estacionSeleccionada) {
                    $paradas[] = $parada;
                }
            }
        }

        $this->dibujaVista(
            "ver",
            [
                "estaciones" => $estaciones,
                "estacionSeleccionada" => $estacionSeleccionada,
                "paradas" => $paradas,
            ],
            "Ver paradas"
        );
    }

    public function accionNueva(): void
    {
        $this->menuizq = [
            ["texto" => "Ver paradas", "enlace" => ["ParadasTray", "ver"]],
        ];

        $this->barraUbi = [
            ["texto" => "Paradas", "enlace" => ["ParadasTray", "ver"]],
            ["texto" => "Nueva parada", "enlace" => ["ParadasTray", "nueva"]],
        ];

        $modelo = new Parada();
        $nombre = $modelo->getNombre();

        if (isset($_POST[$nombre])) {
            $datos = $_POST[$nombre];
            $datos["cod_trayecto"] = intval($datos["cod_trayecto"] ?? 0);
            $datos["estacion"] = trim((string)($datos["estacion"] ?? ""));
            $datos["poblacion"] = trim((string)($datos["poblacion"] ?? ""));
            $datos["es_origen"] = 0;

            $modelo->setValores($datos);

            if (mb_strlen($modelo->estacion) < 5) {
                $modelo->setError("estacion", "La estacion debe tener al menos 5 caracteres");
            }

            $valido = $modelo->validar();

            if (mb_strlen($modelo->estacion) < 5) {
                $modelo->setError("estacion", "La estacion debe tener al menos 5 caracteres");
                $valido = false;
            }

            if ($valido) {
                $this->ParadasTray[$modelo->cod_trayecto] = $modelo;
                $_SESSION["ParadasTray"] = $this->ParadasTray;
                $this->actualizaContadores();
                Sistema::app()->irAPagina(["ParadasTray", "ver"]);
                return;
            }
        }

        $this->dibujaVista("nueva", ["modelo" => $modelo], "Nueva parada");
    }

    public function accionDescargar(): void
    {
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "Debes iniciar sesion para descargar.");
            return;
        }

        if (!in_array(6, $_SESSION["usuario"]["permisos"] ?? [])) {
            Sistema::app()->paginaError(403, "No tienes permiso para descargar paradas.");
            return;
        }

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(400, "No se ha indicado ninguna parada.");
            return;
        }

        $id = intval($_GET["id"]);
        if (!isset($this->ParadasTray[$id])) {
            Sistema::app()->paginaError(404, "La parada indicada no existe.");
            return;
        }

        $parada = $this->ParadasTray[$id];

        header("Content-Type: application/xml; charset=UTF-8");
        header("Content-Disposition: attachment; filename=parada{$parada->cod_trayecto}.xml");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        $this->dibujaVistaParcial("descargar", ["parada" => $parada]);
    }

    private function listaEstaciones(): array
    {
        $estaciones = [];
        foreach ($this->ParadasTray as $parada) {
            $estaciones[$parada->estacion] = $parada->estacion;
        }

        return $estaciones;
    }
}
