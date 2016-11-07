<?php

namespace App\PRS\Helpers;
use Illuminate\Support\Collection;

/**
 * Helpers for ServiceContract elements
 */
class ContractHelpers
{

    /**
     * Get the binary number between 0,127 that represents de days of the week
     * @param  boolean $monday
     * @param  boolean $tuesday
     * @param  boolean $wednesday
     * @param  boolean $thursday
     * @param  boolean $friday
     * @param  boolean $saturday
     * @param  boolean $sunday
     * @return integer
     */
    public function serviceDaysToNum(array $serviceDays){
    	// basicamente es un numero binario de 7 digitos, el numero maximo posible es 2^7 = 128
        $num = 0;
        if($serviceDays['monday']){
            $num += 1;
        }if($serviceDays['tuesday']){
            $num += 2;
        }if($serviceDays['wednesday']){
            $num += 4;
        }if($serviceDays['thursday']){
            $num += 8;
        }if($serviceDays['friday']){
            $num += 16;
        }if($serviceDays['saturday']){
            $num += 32;
        }if($serviceDays['sunday']){
            $num += 64;
        }
        return $num;
    }

}
