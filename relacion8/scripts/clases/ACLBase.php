<?php

 
abstract class ACLBase {

    // 
    //  GESTIÓN DE ROLES 
    // 

    /**
     * Añade un nuevo role con nombre y permisos.
     * Devuelve true si se ha podido añadir, false si ya existe.
     */
    abstract public function anadirRole(string $nombre, array $permisos = []): bool;

    /**
     * Devuelve el código del role dado su nombre, o false si no existe.
     */
    abstract public function getCodRole(string $nombre): int|false;

    /**
     * Comprueba si existe un role con el código indicado.
     */
    abstract public function existeRole(int $codRole): bool;

    /**
     * Devuelve el array de permisos de un role o false si no existe.
     */
    abstract public function getPermisosRole(int $codRole): array|false;

    /**
     * Devuelve el permiso concreto de un role. Si no existe, devuelve false.
     */
    abstract public function getPermisoRole(int $codRole, int $numero): bool;


    
    //  GESTIÓN DE USUARIOS 
    

    /**
     * Añade un nuevo usuario con nombre, nick, contraseña y role.
     * Devuelve true si se ha podido crear.
     */
    abstract public function anadirUsuario(string $nombre, string $nick, string $contrasena, int $codRole): bool;

    /**
     * Devuelve el código de usuario dado su nick, o false si no existe.
     */
    abstract public function getCodUsuario(string $nick): int|false;

    /**
     * Comprueba si existe un usuario con ese código.
     */
    abstract public function existeCodUsuario(int $codUsuario): bool;

    /**
     * Comprueba si existe un usuario con ese nick.
     */
    abstract public function existeUsuario(string $nick): bool;

    /**
     * Comprueba si el nick y la contraseña coinciden. Devuelve true si es válido.
     */
    abstract public function esValido(string $nick, string $contrasena): bool;

    /**
     * Devuelve si el usuario tiene el permiso indicado.
     */
    abstract public function getPermiso(int $codUsuario, int $numero): bool;

    /**
     * Devuelve todos los permisos del usuario.
     */
    abstract public function getPermisos(int $codUsuario): array;

    /**
     * Devuelve el nombre del usuario o false si no existe.
     */
    abstract public function getNombre(int $codUsuario): string|false;

    /**
     * Devuelve si el usuario está marcado como borrado.
     */
    abstract public function getBorrado(int $codUsuario): bool;

    /**
     * Devuelve el código de role del usuario o false si no existe.
     */
    abstract public function getUsuarioRole(int $codUsuario): int|false;

    /**
     * Cambia el nombre del usuario. Devuelve true si se ha podido hacer.
     */
    abstract public function setNombre(int $codUsuario, string $nombre): bool;

    /**
     * Cambia la contraseña del usuario. Devuelve true si se ha podido hacer.
     */
    abstract public function setContrasenia(int $codUsuario, string $contra): bool;

    /**
     * Marca si el usuario está borrado o no. Devuelve true si se ha podido hacer.
     */
    abstract public function setBorrado(int $codUsuario, bool $borrado): bool;

    /**
     * Cambia el role de un usuario. Devuelve true si se ha podido hacer.
     */
    abstract public function setUsuarioRole(int $codUsuario, int $role): bool;


    // 
    //  LISTADOS 

    /**
     * Devuelve array asociativo [codUsuario => nick]
     */
    abstract public function dameUsuarios(): array;

    /**
     * Devuelve array indexado [codRole => nombre]
     */
    abstract public function dameRoles(): array;
}

?>
