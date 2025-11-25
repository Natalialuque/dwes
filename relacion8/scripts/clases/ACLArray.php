<?php


require_once("ACLBase.php");

class ACLArray extends ACLBase {

    // Array privado de roles: [codRole => ['nombre'=>string, 'permisos'=>array]]
    private array $_roles = [];

    // Array privado de usuarios: [codUsuario => ['nombre'=>string, 'nick'=>string, 'contrasena'=>string, 'codRole'=>int, 'borrado'=>bool]]
    private array $_usuarios = [];

    // Contadores autonuméricos
    private int $_contadorRoles = 1;
    private int $_contadorUsuarios = 1;

    public function __construct() {
        // Roles iniciales
        $this->anadirRole("normales", [1 => true]);
        $this->anadirRole("administradores", [1 => true, 2 => true]);

        // Usuarios iniciales
        $this->anadirUsuario("Alumno", "alumno", "1234", $this->getCodRole("normales"));
        $this->anadirUsuario("Profesor", "profesor", "1234", $this->getCodRole("administradores"));
        $this->anadirUsuario("Natalia", "natalia", "1234", $this->getCodRole("administradores"));
    }

    // ============================
    // ==== GESTIÓN DE ROLES ======
    // ============================

    public function anadirRole(string $nombre, array $permisos = []): bool {
        foreach ($this->_roles as $r) {
            if ($r['nombre'] === $nombre) return false;
        }
        $cod = $this->_contadorRoles++;
        $permisosFinal = [];
        for ($i = 1; $i <= 10; $i++) {
            $permisosFinal[$i] = $permisos[$i] ?? false;
        }
        $this->_roles[$cod] = ['nombre' => $nombre, 'permisos' => $permisosFinal];
        return true;
    }

    public function getCodRole(string $nombre): int|false {
        foreach ($this->_roles as $cod => $r) {
            if ($r['nombre'] === $nombre) return $cod;
        }
        return false;
    }

    public function existeRole(int $codRole): bool {
        return isset($this->_roles[$codRole]);
    }

    public function getPermisosRole(int $codRole): array|false {
        return $this->_roles[$codRole]['permisos'] ?? false;
    }

    public function getPermisoRole(int $codRole, int $numero): bool {
        return $this->_roles[$codRole]['permisos'][$numero] ?? false;
    }

    // ==============================
    // ==== GESTIÓN DE USUARIOS =====
    // ==============================

    public function anadirUsuario(string $nombre, string $nick, string $contrasena, int $codRole): bool {
        if (!$this->existeRole($codRole) || $this->existeUsuario($nick)) return false;
        $cod = $this->_contadorUsuarios++;
        $this->_usuarios[$cod] = [
            'nombre' => $nombre,
            'nick' => $nick,
            'contrasena' => password_hash($contrasena, PASSWORD_BCRYPT),
            'codRole' => $codRole,
            'borrado' => false
        ];
        return true;
    }

    public function getCodUsuario(string $nick): int|false {
        foreach ($this->_usuarios as $cod => $u) {
            if ($u['nick'] === $nick) return $cod;
        }
        return false;
    }

    public function existeCodUsuario(int $codUsuario): bool {
        return isset($this->_usuarios[$codUsuario]);
    }

    public function existeUsuario(string $nick): bool {
        return $this->getCodUsuario($nick) !== false;
    }

    public function esValido(string $nick, string $contrasena): bool {
        $cod = $this->getCodUsuario($nick);
        if ($cod === false) return false;
        return password_verify($contrasena, $this->_usuarios[$cod]['contrasena']);
    }

    public function getPermiso(int $codUsuario, int $numero): bool {
        $codRole = $this->getUsuarioRole($codUsuario);
        return $this->getPermisoRole($codRole, $numero);
    }

    public function getPermisos(int $codUsuario): array {
        $codRole = $this->getUsuarioRole($codUsuario);
        return $this->getPermisosRole($codRole) ?? [];
    }

    public function getNombre(int $codUsuario): string|false {
        return $this->_usuarios[$codUsuario]['nombre'] ?? false;
    }

    public function getBorrado(int $codUsuario): bool {
        return $this->_usuarios[$codUsuario]['borrado'] ?? false;
    }

    public function getUsuarioRole(int $codUsuario): int|false {
        return $this->_usuarios[$codUsuario]['codRole'] ?? false;
    }

    public function setNombre(int $codUsuario, string $nombre): bool {
        if (!$this->existeCodUsuario($codUsuario)) return false;
        $this->_usuarios[$codUsuario]['nombre'] = $nombre;
        return true;
    }

    public function setContrasenia(int $codUsuario, string $contra): bool {
        if (!$this->existeCodUsuario($codUsuario)) return false;
        $this->_usuarios[$codUsuario]['contrasena'] = password_hash($contra, PASSWORD_BCRYPT);
        return true;
    }

    public function setBorrado(int $codUsuario, bool $borrado): bool {
        if (!$this->existeCodUsuario($codUsuario)) return false;
        $this->_usuarios[$codUsuario]['borrado'] = $borrado;
        return true;
    }

    public function setUsuarioRole(int $codUsuario, int $role): bool {
        if (!$this->existeCodUsuario($codUsuario) || !$this->existeRole($role)) return false;
        $this->_usuarios[$codUsuario]['codRole'] = $role;
        return true;
    }

    // ==============================
    // ========= LISTADOS ===========
    // ==============================

    public function dameUsuarios(): array {
        $resultado = [];
        foreach ($this->_usuarios as $cod => $u) {
            $resultado[$cod] = $u['nick'];
        }
        return $resultado;
    }

    public function dameRoles(): array {
        $resultado = [];
        foreach ($this->_roles as $cod => $r) {
            $resultado[$cod] = $r['nombre'];
        }
        return $resultado;
    }
}

?>