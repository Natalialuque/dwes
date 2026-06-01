<?php
//clase libro, albergamos una serie de propiedades y de metodos, ademas tenemos constructor 

class libro implements Iterator {

    //dos propiedades privadas 
    private String $_nombre;
    private String $_autor;

    //propiedad dinamica (array)
    private array $_otras = [];

    //necesitamos un puntero para recorrer el iterator 
    private int $punte = 0;

    /**
     * Constructor
     */
    public function __construct(String $nombre, String $autor, ...$params)
    {
    // Asignamos nombre y autor usando __set
    $this->__set("nombre", $nombre);
    $this->__set("autor", $autor);

    // Recorremos las propiedades dinámicas en parejas
    $total = count($params);

    for ($i = 0; $i < $total - 1; $i += 2) {

        $nombreProp = $params[$i];
        $valorProp  = $params[$i + 1];

        // El enunciado exige que el nombre de propiedad sea string
        if (!is_string($nombreProp)) {
            continue;
        }

        // Usamos __set para que normalice y guarde correctamente
        $this->__set($nombreProp, $valorProp);
    }
    }


    /**
     * Implementacion de los metodos de sobrecarga
     */
      public function __set(String $name,mixed $value)
    {
        $name = mb_strtolower($name); //convertimos a minuscula para comprobar bien

        //Primero el nombre
        if($name === "nombre"){
             $this ->_nombre=$value;
             return;
        }

        //segundo el autor 
        if($name === "autor"){
             $this ->_autor=$value;
             return;
        }

        // propiedad dinámica
            //   - todo minúsculas
        $propLower = mb_strtolower($name);
            //   - última letra en mayúscula
        $ultima = mb_strtoupper(substr($propLower, -1));
            //lo escribe todo 
        $claveInterna = mb_substr($propLower, 0, -1) . $ultima;

        // Guardamos en el array de dinámicas
        $this->_otras[$claveInterna] = $value;

    }

    public function __get(String $name){
        $name = mb_strtolower($name); //convertimos a minuscula para comprobar bien

        //Primero el nombre
        if($name === "nombre"){
            return $this ->_nombre;
        }

        //segundo el autor 
        if($name === "autor"){
            return $this ->_autor;
        }

        // propiedad dinámica
        // Normalizamos igual que en __set
        $propLower = strtolower($name);
        $ultima = strtoupper(substr($propLower, -1));
        $claveInterna = substr($propLower, 0, -1) . $ultima;

        return $this->_otras[$claveInterna] ?? null;

    }

    public function __isset(String $name)
    {
        $propLower = mb_strtolower($name);
        if ($propLower === "nombre" || $propLower === "autor") return true;

        $ultima = mb_strtoupper(mb_substr($propLower, -1));
        $claveInterna = mb_substr($propLower, 0, -1) . $ultima;

        return isset($this->_otras[$claveInterna]);
    }

    public function __unset(String $name)
    {
        $propLower = strtolower($name);
        if ($propLower === "nombre" || $propLower === "autor") return;

        $ultima = strtoupper(substr($propLower, -1));
        $claveInterna = mb_substr($propLower, 0, -1) . $ultima;

        unset ($this->_otras[$claveInterna]);
    }


    /**
     * Implementacion de los metodos de iterator
     */

    //puntero de la primera posicion 
    public function rewind(): void {
        $this ->punte=0;
    }

    public function valid(): bool {
        return $this->punte <= count($this->_otras) + 1;
    }

    //devuelve elemento actual 
    public function current(): mixed {

        //si estamos en posicion 0 devolvemos el nombre 
        if($this->punte===0){return $this->_nombre;}

        //si estamos entre 1 y n, devolvemos el array 
        $totalDinamicas = count($this->_otras); //saca total del array
        if ($this->punte >= 1 && $this->punte <= $totalDinamicas) {
             $valores = array_values($this->_otras);//valores en orden
             return $valores[$this->punte - 1]; //los devuelve desde el primero
         }

        //si el array ha terminado devolvemos el autor 
        if($this->punte === $totalDinamicas+1){return $this->_autor;}

        return null;
    
    }

    //para devolver la clave y ten en cuenta que va minuscula
    public function key(): mixed {
        //si estamos en posicion 0 devolvemos la clave del nombre 
        if($this->punte===0){return "nombre";}

        //si estamos entre 1 y n, devolvemos el array, meter minuscula
        $totalDinamicas = count($this->_otras); //saca total del array
        if ($this->punte >= 1 && $this->punte <= $totalDinamicas) {
             $claves = array_keys($this->_otras);//saco las claves mediante array_keys
             return mb_strtolower($claves[$this->punte - 1]); //devuelve claves en minuscula
         }

        //si el array ha terminado devolvemos la clave de autor
        if($this->punte === $totalDinamicas+1){return "autor";}

        return null;        
    }

    //pasa al siguiente 
    public function next(): void {
        $this -> punte++;
    }

}