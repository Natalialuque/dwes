<?php
    class ClaseSinsobrecarga
    {
        public int $num=124;


        //deshabilito la sobrecarga
        public function __set(string $name, mixed $value):void
        {
           throw new Exception("no existe la propiedad $name");
        }

        public function __get($name):mixed
        {
            throw new Exception("no existe la propiedad $name");
        }

        public function __isset($name):bool
        {
            return false;
        }

        public function __unset($name):void
        {
           ;
        }
    }

