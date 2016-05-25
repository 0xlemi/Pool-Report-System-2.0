<?php

namespace App\PRS\Transformers;

abstract class Transformer{

  /**
    * transform object collection into api output
    * @param   $items
    * @return array
    */
   public function transformCollection(array $items)
   {
       return array_map(function($item){
         return $this->transform($item);
       }, $items);
   }

}
