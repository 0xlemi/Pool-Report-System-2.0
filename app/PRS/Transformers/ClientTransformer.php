<?php

namespace App\PRS\Transformers;

use App\Client;
use App\Service;

use App\PRS\Transformers\SupervisorTransformer;
use App\PRS\Transformers\ImageTransformer;

use Auth;

/**
 * Transformer for the technician class
 */
class ClientTransformer extends Transformer
{

    private $serviceTransformer;
    private $imageTransformer;

    public function __construct(ServiceTransformer $serviceTransformer, ImageTransformer $imageTransformer)
    {
        $this->serviceTransformer = $serviceTransformer;
        $this->imageTransformer = $imageTransformer;
    }


    public function transform(Client $client)
    {
        $services = $client->services()->get();
        $all_services  = array();
        foreach($services as $service){
            $all_services[] = $this->serviceTransformer->transform($service);
        }

        $photo = 'no image';
        if($client->imageExists()){
            $photo = $this->imageTransformer->transform($client->image(1, false));
        }

        return [
            'id' => $client->seq_id,
            'name' => $client->name,
            'last_name' => $client->last_name,
            'email' => $client->user()->email,
            'cellphone' => $client->cellphone,
            'type' => ($client->type == 1) ? 'Owner' : 'House Admin',
            'language' => $client->language,
            'getReportsEmails' => $client->get_reports_emails,
            'comments' => $client->comments,
            'photo' => $photo,
            'services' =>
                $all_services
                // $this->$serviceTransformer->transformCollection($client->services()->get())
        ];
    }


}
