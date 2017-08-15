<?php
namespace App\PRS\Classes\DeviceMagic;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\PRS\Classes\DeviceMagic\Form;
use App\PRS\Classes\DeviceMagic\Destination;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class ReportForm extends Form {

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
        if($formId = $this->company->report_form_id){
            return $this->update($formId);
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
                    "title" => "Make Report / Crear Reporte",
                    "description" => $this->company->name
                ]
            ]
        );

        $formId = json_decode($response->getBody()->getContents())->id;
        $this->company->report_form_id = $formId;
        $this->company->save();
        if($destination = $this->destination->add($formId, null, '/report')){
            $this->company->report_destination_id = $destination->id;
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
                        "title" => "Make Report / Crear Reporte",
                        "description" => $this->company->name
                    ]
                ]
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                $this->company->report_form_id = null;
                $this->company->report_destination_id = null;
                $this->company->save();
                throw new Exception("There was not a Report Form", 1);
                return false;
            }
        }

        if($destination = $this->destination->add($formId, $this->company->report_destination_id, '/report')){
            $this->company->report_destination_id = $destination->id;
            $this->company->save();
        }

        return $this->updateGroup($formId);
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
        return [
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
                "identifier" => "image_1",
                "title" => "Image 1 (Full Pool / Alberca Completa)",
                "type" => "image",
                "required_rule" => "always",
                "extra_large" => true,
                "camera_only" => true,
                "hint" => "PICTURES SHOULD BE LANDSCAPE / TOMAR FOTO ACOSTADA",
                "timestamp" => true,
                "geostamp" => true
            ],
            [
                "identifier" => "image_2",
                "title" => "Image 2 (Water Quality / Calidad del Agua)",
                "type" => "image",
                "required_rule" => "always",
                "extra_large" => true,
                "camera_only" => true,
                "hint" => "PICTURES SHOULD BE LANDSCAPE / TOMAR FOTO ACOSTADA"
            ],
            [
                "identifier" => "image_3",
                "title" => "Image 3 (Engine Room / Cuarto de Maquinas)",
                "type" => "image",
                "required_rule" => "always",
                "extra_large" => true,
                "camera_only" => true,
                "hint" => "PICTURES SHOULD BE LANDSCAPE / TOMAR FOTO ACOSTADA"
            ],
            [
                "identifier" => "image_4",
                "title" => "Image 4 (Optional Extra Image)",
                "type" => "image",
                "visible_rule" => "when",
                "extra_large" => true,
                "camera_only" => true,
                "visible_expr" => "AND(AND(NOTBLANK(image_1),NOTBLANK(image_2)),NOTBLANK(image_3))",
                "hint" => "PICTURES SHOULD BE LANDSCAPE / TOMAR FOTO ACOSTADA"
            ],
            [
                "identifier" => "image_5",
                "title" => "Image 5 (Optional Extra Image)",
                "type" => "image",
                "visible_rule" => "when",
                "extra_large" => true,
                "camera_only" => true,
                "visible_expr" => "AND(AND(AND(NOTBLANK(image_1),NOTBLANK(image_2)),NOTBLANK(image_3)),NOTBLANK(image_4))",
                "hint" => "PICTURES SHOULD BE LANDSCAPE / TOMAR FOTO ACOSTADA"
            ]
        ];
    }

}
