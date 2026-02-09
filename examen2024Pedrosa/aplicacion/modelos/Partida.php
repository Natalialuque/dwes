<?php

class Partida extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return 'partida';
    }

    protected function fijarAtributos(): array
    {
        return ["cod_partida", "mesa", "fecha", "cod_baraja", "nombre_baraja", "jugadores", "crupier"];
    }

    protected function fijarDescripciones(): array
    {
        return [
            "cod_partida" => "Parti-Código Partida",
            "mesa" => "Parti-Número mesa",
            "fecha" => "Parti-Fecha",
            "cod_baraja" => "Parti-Código Baraja",
            "nombre_baraja" => "Parti-Nombre Baraja",
            "jugadores" => "Parti-Número jugadores",
            "crupier" => "Parti-Nombre crupier"
        ];
    }

    protected function fijarRestricciones(): array
    {
        return [
            [
                "ATRI" => "cod_partida,cod_baraja",
                "TIPO" => "REQUERIDO"
            ],
            [
                "ATRI" => "cod_partida",
                "TIPO" => "ENTERO",
                "MIN" => 21
            ],
            [
                "ATRI" => "mesa",
                "TIPO" => "ENTERO",
                "MIN" => 1,
                "MAX" => 20,
                "DEFECTO" => 1
            ],
            [
                "ATRI" => "fecha",
                "TIPO" => "FECHA",
            ],
            [
                "ATRI" => "fecha",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaFecha"
            ],
            [
                "ATRI" => "cod_baraja",
                "TIPO" => "ENTERO"
            ],
            [
                "ATRI" => "cod_baraja",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaBaraja"
            ],
            [
                "ATRI" => "nombre_baraja",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
            ],
            [
                "ATRI" => "jugadores",
                "TIPO" => "ENTERO",
            ],
            [
                "ATRI" => "jugadores",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaJugadores"
            ],
            [
                "ATRI" => "crupier",
                "TIPO" => "CADENA",
                "TAMANIO" => 30
            ],
            [
                "ATRI" => "crupier",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaCrupier"
            ]
        ];
    }

    // Valida que la fehca sea valida 
    public function validaFecha(): bool
    {
        $campo = "fecha";

        // Comprobar que viene algo
        if (empty($this->$campo)) {
            $this->setError($campo, "La fecha es obligatoria");
            return false;
        }

        // Si viene en formato HTML5 (YYYY-MM-DD), convertirlo a dd/mm/YYYY
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->$campo)) {
            $this->$campo = date("d/m/Y", strtotime($this->$campo));
        }

        // Intentar crear la fecha en formato dd/mm/YYYY
        $fecha = DateTime::createFromFormat('d/m/Y', $this->$campo);

        if ($fecha === false) {
            $this->setError($campo, "La fecha no tiene un formato válido (dd/mm/yyyy)");
            return false;
        }

        // Fecha mínima
        $hoy = new DateTime("today");

        if ($fecha < $hoy) {
            $this->setError($campo, "La fecha no puede ser anterior a hoy");
            return false;
        }

        return true;
    }


    public function validaBaraja()
    {
        if (Listas::listaTiposBarajas(false, $this->cod_baraja) === false)
            $this->setError("cod_baraja", "Código de baraja debe estar entre las barajas");
    }

    public function validaJugadores()
    {
        $array = Listas::listaTiposBarajas(true, $this->cod_baraja);
        if ($this->jugadores < $array["min_juga"] || $this->jugadores > $array["max_juga"])
            $this->setError("jugadores", "Número de jugadores no permitido");
    }

    public function validaCrupier()
    {
        $sub = mb_substr($this->crupier, 0, 4);
        if ($sub !== "Cru-")
            $this->setError("crupier", "El nombre de crupier debe empezar por Cru-");
    }

    public function afterCreate(): void
    {
        $this->cod_partida = 0;
        $this->jugadores = 0;
        $this->cod_baraja = array_keys(Listas::listaTiposBarajas(true))[floor(count(array_keys(Listas::listaTiposBarajas(true))) / 2)];
        $this->nombre_baraja = Listas::listaTiposBarajas(false, $this->cod_baraja);
        $this->fecha = date("Y/m/d", strtotime("+1 day"));
    }


    /**
     * VALIDAR
     */

    //Función que valida contraseña
    public function validaPassword(): bool
    {
        $campo = "password";

        if (empty($this->$campo)) {
            $this->setError($campo, "La contraseña es obligatoria");
            return false;
        }

        $pass = $this->$campo;

        if (strlen($pass) < 8) {
            $this->setError($campo, "Debe tener al menos 8 caracteres");
            return false;
        }

        if (!preg_match('/[A-Z]/', $pass)) {
            $this->setError($campo, "Debe contener al menos una mayúscula");
            return false;
        }

        if (!preg_match('/[a-z]/', $pass)) {
            $this->setError($campo, "Debe contener al menos una minúscula");
            return false;
        }

        if (!preg_match('/[0-9]/', $pass)) {
            $this->setError($campo, "Debe contener al menos un número");
            return false;
        }

        return true;
    }

    //Función que válida Email
    public function validaEmail(): bool
    {
        $campo = "email";

        if (empty($this->$campo)) {
            $this->setError($campo, "El email es obligatorio");
            return false;
        }

        if (!filter_var($this->$campo, FILTER_VALIDATE_EMAIL)) {
            $this->setError($campo, "El email no tiene un formato válido");
            return false;
        }

        return true;
    }

    //Funciión que valida URL
    public function validaURL(): bool
    {
        $campo = "url";

        if (empty($this->$campo)) {
            $this->setError($campo, "La URL es obligatoria");
            return false;
        }

        if (!filter_var($this->$campo, FILTER_VALIDATE_URL)) {
            $this->setError($campo, "La URL no es válida");
            return false;
        }

        return true;
    }

    //Valida NSS
    public function validaNSS(): bool
    {
        $campo = "nss";

        if (empty($this->$campo)) {
            $this->setError($campo, "El NSS es obligatorio");
            return false;
        }

        if (!preg_match('/^\d{12}$/', $this->$campo)) {
            $this->setError($campo, "El NSS debe tener 12 dígitos");
            return false;
        }

        return true;
    }

    //Válida DNI
    public function validaDNI(): bool
    {
        $campo = "dni";

        if (!preg_match('/^\d{8}[A-Za-z]$/', $this->$campo)) {
            $this->setError($campo, "El DNI debe tener 8 números y una letra");
            return false;
        }

        $numero = substr($this->$campo, 0, 8);
        $letra  = strtoupper(substr($this->$campo, -1));
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";

        if ($letras[$numero % 23] !== $letra) {
            $this->setError($campo, "La letra del DNI no es correcta");
            return false;
        }

        return true;
    }

    //Valida TLF
    public function validaTelefono(): bool
    {
        $campo = "telefono";

        if (!preg_match('/^[6-9]\d{8}$/', $this->$campo)) {
            $this->setError($campo, "El teléfono debe tener 9 dígitos y empezar por 6, 7, 8 o 9");
            return false;
        }

        return true;
    }

    //Valida IBAN
    public function validaIBAN(): bool
    {
        $campo = "iban";

        if (!preg_match('/^ES\d{22}$/', $this->$campo)) {
            $this->setError($campo, "El IBAN debe empezar por ES y tener 24 caracteres");
            return false;
        }

        return true;
    }

    //Valida Nombre
    public function validaNombre(): bool
    {
        $campo = "nombre";

        if (!preg_match('/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]+$/', $this->$campo)) {
            $this->setError($campo, "El nombre solo puede contener letras y espacios");
            return false;
        }

        return true;
    }
}