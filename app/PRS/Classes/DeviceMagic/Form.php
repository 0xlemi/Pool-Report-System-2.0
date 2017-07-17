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

class Form {

    public $company;
    public $destination;

    public function __construct(Company $company, Destination $destination)
    {
        $this->company = $company;
        $this->destination = $destination;
    }

    public function updateReport()
    {
        if($form_id = $this->company->form_id){
            return $this->updateRequest($form_id);
        }
        return $this->createRequest($this->company);
    }

    protected function createRequest()
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $services = $this->company->services()->withActiveContract()
            ->get()->transform(function($service){
                return (object) [
                    "identifier" => $service->seq_id,
                    "text" => $service->seq_id." ".$service->name,
                ];
        });
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/forms",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "type" => "root",
                    "children" => [
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
                    ],
                    "title" => "Make Report / Crear Reporte",
                    "description" => $this->company->name
                ]
            ]
        );

        $this->company->form_id = json_decode($response->getBody()->getContents())->id;
        $this->company->save();
        $this->destination->add();

        return $this->updateGroup($this->company);
    }

    protected function updateRequest(int $form_id)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');

        $services = $this->company->services()->withActiveContract()
                ->get()->transform(function($service){
                    return (object) [
                        "identifier" => $service->seq_id,
                        "text" => $service->seq_id." ".$service->name,
                    ];
        });
        try {
            $response =  Guzzle::put(
                "https://www.devicemagic.com/organizations/{$org_id}/forms/{$form_id}",
                [
                    'headers' => [
                        'Authorization' => $auth,
                        'Content-Type' => 'application/json'
                    ],
                    'json' => [
                        "type" => "root",
                        "children" => [
                            [
                                "identifier" => "service",
                                "title" => "Select Service / Seleccionar Servicio",
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
                        ],
                        "title" => "Make Report / Crear Reporte",
                        "description" => $this->company->name
                    ]
                ]
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                $this->company->form_id = null;
                $this->company->save();
                return response()->json(['message' => 'Cannot update form that don\'t exitst. Please try again'], 404);
            }
        }

        $this->destination->add();

        return $this->updateGroup();
    }

    protected function updateGroup()
    {
        if(!$this->company->form_id || !$this->company->group_id){
            return false;
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/forms/{$this->company->form_id}/properties",
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


}
