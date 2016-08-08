<?php

namespace App\PRS\Transformers;

use App\Supervisor;

use App\PRS\Transformers\ImageTransformer;


/**
 * Transformer for the supervisor class
 */
class SupervisorTransformer extends Transformer
{

    private $imageTransformer;

    public function __construct(ImageTransformer $imageTransformer)
    {
        $this->imageTransformer = $imageTransformer;
    }

    public function transform(Supervisor $supervisor)
    {
        return [
            'id' => $supervisor->seq_id,
            'name' => $supervisor->name,
            'last_name' => $supervisor->last_name,
            'email' => $supervisor->user()->email,
            'cellphone' => $supervisor->cellphone,
            'address' => $supervisor->address,
            'language' => $supervisor->language,
            'comments' => $supervisor->comments,
            'photo' => $this->imageTransformer->transform($supervisor->image(1, false)),
        ];
    }


}
