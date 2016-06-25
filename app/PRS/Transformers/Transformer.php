<?php

namespace App\PRS\Transformers;


abstract class Transformer{


  /**
    * transform object collection into api output
    * @param   $items
    * @return array
    */
   public function transformCollection($items)
   {
       $all_items = array();
       foreach ($items as $item) {
           $all_items[] = $this->transform($item);
       }
       return $all_items;
   }

}
