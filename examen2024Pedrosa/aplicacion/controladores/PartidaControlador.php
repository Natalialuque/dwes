<?php
class PartidaControlador extends CControlador
{
    public array $menuizq = [];
    public array $partidas = [];
    public int $N_Partidas = 0;
    public int $N_PartidasHoy = 0;

    public function __construct()
    {
        parent::__construct();

        Sistema::app()->sesion()->crearSesion();

        if (isset($_SESSION["Partidas"])) {
            $this->partidas = $_SESSION["Partidas"];
        } else {
            $this->inicializarPartidas();
        }

        $this->N_Partidas = count($this->partidas);
        $this->calcularPartidasHoy();
    }

 public function accionIndex()
{
    $this->menuizq = [
        ["texto" => "Inicio", "enlace" => ["partida"]]
    ];

    $this->dibujaVista(
        "index",
        [
            "partidas" => $this->partidas,
            "N_Partidas" => $this->N_Partidas,
            "N_PartidasHoy" => $this->N_PartidasHoy
        ],
        "Listado de Partidas"
    );
}


   private function inicializarPartidas()
{
    $this->partidas = [];

    $codigos = [5, 6, 7];

    for ($i = 1; $i <= 4; $i++) {

        $p = new Partida();

        $p->cod_partida = $i;
        $p->mesa = $i + 1;
        $p->fecha = date("Y-m-d", strtotime("+$i day"));
        $p->cod_baraja = $codigos[$i - 1];
        $p->jugadores = 4;
        $p->crupier = "Cru-Init$i";
        $p->nombre_baraja = ""; // según enunciado

        $this->partidas[$i] = $p;
    }

    $_SESSION["Partidas"] = $this->partidas;
    $this->N_Partidas = count($this->partidas);
}

    private function calcularPartidasHoy()
    {
        $hoy = date("Y-m-d");
        $this->N_PartidasHoy = 0;

        foreach ($this->partidas as $p) {
            if ($p->fecha === $hoy) {
                $this->N_PartidasHoy++;
            }
        }
    }
}