<?php

namespace PMT\APP\CORE\ABSTRACT;

abstract class AbstractEntity{
   abstract static public function toObject($data):static;
   abstract static public function toArray():array;
   public static function toJson(){
    return json_encode($this->toArray());
   }



}