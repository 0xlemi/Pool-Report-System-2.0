<?php

namespace App\PRS\Transformers;
use App\Chemical;


/**
 * Transformer for the Chemical class
 */
class ChemicalTransformer extends Transformer
{

    /**
     * Transform Chemical into api readable array
     * @param  Chemical $chemical
     * @return array
     * tested
     */
    public function transform(Chemical $chemical)
    {
        return [
            'id' => $chemical->id,
            'name' => $chemical->name,
            'amount' => $chemical->amount,
            'units' => $chemical->units,
        ];
    }

}
