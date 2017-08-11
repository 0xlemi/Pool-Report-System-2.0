<?php
namespace App\PRS\Classes\DeviceMagic;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Destination;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class WorkOrderForm {

    protected $company;
    protected $destination;

    public function __construct(Destination $destination)
    {
        $this->company = $destination->getCompany();
        $this->destination = $destination;
    }

    public function createOrUpdate()
    {
        if($this->company->services()->withActiveContract()->count() < 1){
            throw new Exception("DeviceMagic Form With No Services.");
        }
        if($form_id = $this->company->work_order_form_id ){
            return $this->update($form_id);
        }
        return $this->create();
    }

    protected function create()
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/forms",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "type" => "root",
                    "children" => $this->formJson(),
                    "title" => "Work Orders / Ordenes de Trabajo",
                    "description" => $this->company->name
                ]
            ]
        );

        $formId = json_decode($response->getBody()->getContents())->id;
        $this->company->work_order_form_id = $formId;
        $this->company->save();
        if($destination = $this->destination->add($formId, null, '/workorder')){
            $this->company->work_order_destination_id = $destination->id;
            $this->company->save();
        }

        return $this->updateGroup($formId);
    }

    protected function update(int $formId)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        try {
            $response =  Guzzle::put(
                "https://www.devicemagic.com/organizations/{$org_id}/forms/{$formId}",
                [
                    'headers' => [
                        'Authorization' => $auth,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => [
                        "type" => "root",
                        "children" => $this->formJson(),
                        "title" => "Work Orders / Ordenes de Trabajo",
                        "description" => $this->company->name
                    ]
                ]
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                $this->company->work_order_form_id  = null;
                $this->company->work_order_destination_id  = null;
                $this->company->save();
                throw new Exception("There was not a Work Order Form", 1);
                return false;
            }
        }

        if($destination = $this->destination->add($formId, $this->company->work_order_destination_id, '/workorder')){
            $this->company->work_order_destination_id = $destination->id;
            $this->company->save();
        }

        return $this->updateGroup($formId);
    }

    protected function updateGroup($formId)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/forms/{$formId}/properties",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "group" => "PRS-{$this->company->name}-{$this->company->id}"
                ]
            ]
        );

        return ($response->getStatusCode() === 200);
    }

    protected function formJson()
    {
        $services = $this->company->services()->withActiveContract()->orderBy('services.seq_id')
            ->get()->transform(function($service){
                return (object) [
                    "identifier" => $service->seq_id,
                    "text" => $service->seq_id." ".$service->name,
                ];
        });
        $currencies = collect(config('constants.currencies'))->transform(function ($item) {
            return (object)[
                "text" => $item
            ];
        });
        return [
            [
                "identifier" => "title",
                "title" => "Title",
                "type" => "text",
                "required_rule" => "always"
            ],
            [
                "identifier" => "service",
                "title" => "Select Service / Seleccionar Servicio",
                "options" => [],
                "type" => "select",
                "required_rule" => "always",
                "options" => $services,
                "customOptionIdentifiers" => true,
            ],
            [
                "identifier" => "price",
                "title" => "Price",
                "type" => "decimal",
                "required_rule" => "always"
            ],
            [
                "identifier" => "currency",
                "title" => "Currency",
                "options" => $currencies,
                "type" => "select",
                "required_rule" => "always"
            ],
            [
                "identifier" => "start_at",
                "title" => "Started At",
                "type" => "datetime",
                "required_rule" => "always"
            ],
            [
                "identifier" => "description",
                "title" => "Description",
                "type" => "text",
                "required_rule" => "always",
                "multi_line" => true,
                "hint" => "Descrive in detail the work you are doing / Describe en detalle el trabajo que se va a hacer"
            ],
            [
                "identifier" => "image_1",
                "title" => "Image 1",
                "type" => "image",
                "camera_only" => true,
                "hint" => "Image of the site before work is done / Imagen del sitio antes de hacer trabajo"
            ],
            [
                "identifier" => "image_2",
                "title" => "Image 2",
                "type" => "image",
                "visible_rule" => "when",
                "camera_only" => true,
                "hint" => "Image of the site before work is done / Imagen del sitio antes de hacer trabajo",
                "visible_expr" => "NOTBLANK(image_1)"
            ],
            [
                "identifier" => "image_3",
                "title" => "Image 3",
                "type" => "image",
                "visible_rule" => "when",
                "camera_only" => true,
                "hint" => "Image of the site before work is done / Imagen del sitio antes de hacer trabajo",
                "visible_expr" => "AND(NOTBLANK(image_1),NOTBLANK(image_2))"
            ],
            [
                "identifier" => "image_4",
                "title" => "Image 4",
                "type" => "image",
                "visible_rule" => "when",
                "camera_only" => true,
                "hint" => "Image of the site before work is done / Imagen del sitio antes de hacer trabajo",
                "visible_expr" => "AND(AND(NOTBLANK(image_1),NOTBLANK(image_2)),NOTBLANK(image_3))"
            ],
            [
                "identifier" => "image_5",
                "title" => "Image 5",
                "type" => "image",
                "visible_rule" => "when",
                "camera_only" => true,
                "hint" => "Image of the site before work is done / Imagen del sitio antes de hacer trabajo",
                "visible_expr" => "AND(AND(AND(NOTBLANK(image_1),NOTBLANK(image_2)),NOTBLANK(image_3)),NOTBLANK(image_4))"
            ]
        ];
    }


}
