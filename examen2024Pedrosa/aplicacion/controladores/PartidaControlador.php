<?php
class partidaControlador extends CControlador
{
    public array $menuizq = [];
    public array $partidas = [];
    public int $N_Partidas = 0;
    public int $N_PartidasHoy = 0;

    public function __construct()
    {
        parent::__construct();

        Sistema::app()->sesion()->crearSesion();
        unset($_SESSION["Partidas"]);
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
        ["texto" => "Inicio", "enlace" => ["partida"]],
    ];

    $this->dibujaVista(
        "index",
        [
            "N_Partidas" => $this->N_Partidas,
            "N_PartidasHoy" => $this->N_PartidasHoy,
            "partidas" => $this->partidas
        ],
        "Listado de Partidas"
    );
}


    // LOGIN
     public function accionLogin()
     {
         // Debe haber 1 o más partidas HOY
         if ($this->N_PartidasHoy < 1) {
             Sistema::app()->paginaError(400, "No puedes hacer login: no hay partidas previstas para hoy.");
             return;
         }

         // Registrar usuario
         $_SESSION["usuario"] = [
             "nick" => "Natalia",
            "permisos" => [2, 4, 6]
        ];

         $this->dibujaVista("login", [], "Login correcto");
     }

    // // LOGOUT
     public function accionLogout()
     {
         // Debe haber usuario registrado
         if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "No puedes hacer logout: no hay usuario registrado.");
             return;
         }

        // Debe haber 2 o más partidas (da igual el día)
         if ($this->N_Partidas < 2) {
             Sistema::app()->paginaError(400, "No puedes hacer logout: no hay suficientes partidas.");
             return;
         }

         unset($_SESSION["usuario"]);

        $this->dibujaVista("logout", [], "Logout correcto");
     }

    // INICIALIZAR PARTIDAS
    private function inicializarPartidas()
    {
        $this->partidas = [];

        // Lista completa de barajas
        $lista = listas::listaTiposBarajas();
        $codigos = array_keys($lista);

        for ($i = 1; $i <= 3; $i++) {

            $p = new partida();

            // Código de baraja válido
            $codBaraja = $codigos[$i - 1];

            // AQUÍ ESTÁ LA CLAVE: obtener datos completos
         $datosBaraja = listas::listaTiposBarajas(false, $codBaraja);
            
        if ($datosBaraja === false) {
            $nombreBaraja = "Desconocido";
        } else {
            $nombreBaraja = $datosBaraja;
        }

            $p->setValores([
                "cod_partida" => $i,
                "mesa" => $i + 1,
                "fecha" => date("Y-m-d", strtotime("+" . ($i - 1) . " day")),
                "cod_baraja" => $codBaraja,
                "nombre_baraja" => $nombreBaraja,
                "jugadores" => 4,
                "crupier" => "Cru-Init$i"
            ]);

            $p->guardar();

            $this->partidas[$i] = $p;
        }

        $_SESSION["Partidas"] = $this->partidas;
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