<?php

namespace App\PRS\Transformers;

use App\Client;
use App\Service;

use App\PRS\Transformers\PreviewTransformers\ServicePreviewTransformer;
use App\PRS\Transformers\ImageTransformer;

use Auth;

/**
 * Transformer for the client class to api readible array
 */
class ClientTransformer extends Transformer
{

    private $servicePreviewTransformer;
    private $imageTransformer;

    public function __construct(ServicePreviewTransformer $servicePreviewTransformer, ImageTransformer $imageTransformer)
    {
        $this->servicePreviewTransformer = $servicePreviewTransformer;
        $this->imageTransformer = $imageTransformer;
    }

    /**
     * Transform Client to api readible array
     * @param  Client $client
     * @return array
     * tested
     */
    public function transform(Client $client)
    {
        $services = $this->servicePreviewTransformer->transformCollection($client->services()->get());

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
            'services' => $services,
        ];
    }


}
