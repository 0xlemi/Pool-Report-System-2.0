<?php

namespace App\PRS\Transformers;

use App\Client;
use App\Service;

use App\PRS\Transformers\SupervisorTransformer;

use Auth;

/**
 * Transformer for the technician class
 */
class ClientTransformer extends Transformer
{

    private $serviceTransformer;

    public function __construct(ServiceTransformer $serviceTransformer)
    {
        $this->serviceTransformer = $serviceTransformer;
    }


    public function transform(Client $client)
    {
        $services = $client->services()->get();
        $all_services  = array();
        foreach($services as $service){
            $all_services[] = $this->serviceTransformer->transform($service);
        }

        return [
            'id' => $client->seq_id,
            'name' => $client->name,
            'last_name' => $client->last_name,
            'email' => $client->user()->email,
            'cellphone' => $client->cellphone,
            'type' => ($client->type == 1) ? 'Owner' : 'House Admin',
            'language' => $client->language,
            'comments' => $client->comments,
            'services' =>
                $all_services
                // $this->$serviceTransformer->transformCollection($client->services()->get())
        ];
    }


}
