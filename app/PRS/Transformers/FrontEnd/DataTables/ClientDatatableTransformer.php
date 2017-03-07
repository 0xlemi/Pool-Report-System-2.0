<?php

namespace App\PRS\Transformers\FrontEnd\DataTables;

use App\PRS\Transformers\Transformer;
use App\PRS\Helpers\ClientHelpers;
use App\Client;


/**
 * Transformer for the client class
 */
class ClientDatatableTransformer extends Transformer
{

    private $helper;

    public function __construct(ClientHelpers $helper)
    {
        $this->helper = $helper;
    }

    /**
     * Transform client for today's route to datatable friendly array
     * @param  client $client
     * @return array
     */
    public function transform(Client $client)
    {
        return [
            'id' => $client->seq_id,
            'name' => $client->name.' '.$client->last_name,
            'email' => $client->user->email,
            'type' => $this->helper->styledType($client->type, true, false),
            'cellphone' => $client->cellphone,
        ];
    }

}
