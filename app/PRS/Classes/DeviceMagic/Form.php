<?php
namespace App\PRS\Classes\DeviceMagic;

use Guzzle;
use Uuid;
use Excel;
use Storage;
use App\PRS\Classes\Logged;
use App\Company;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;

class Form {

    public function updateReport(Company $company)
    {
        if($form_id = $company->form_id){
            return $this->updateRequest($company, $form_id);
        }
        return $this->createRequest($company);
    }

    protected function createRequest(Company $company)
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
                    "children" => [
                        [
                            "identifier" => "service",
                            "title" => "Select Service / Seleccionar Servicio",
                            "options" => [],
                            "type" => "select",
                            "required_rule" => "always",
                            "options_resource" => "ab093910-4584-0135-3efa-22000a984cfd",
                            "options_table" => "ab07eda0-4584-0135-3efa-22000a984cfd",
                            "options_text_column" => "ab07f080-4584-0135-3efa-22000a984cfd",
                            "options_identifier_column" => "ab07efd0-4584-0135-3efa-22000a984cfd"
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
                        ]
                    ],
                    "title" => "Make Report / Crear Reporte",
                    "description" => $company->name
                ]
            ]
        );

        $company->form_id = json_decode($response->getBody()->getContents())->id;
        $company->save();

        return $this->updateGroup($company);
    }

    protected function updateRequest(Company $company, int $form_id)
    {
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
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
                                "options" => [],
                                "type" => "select",
                                "required_rule" => "always",
                                "options_resource" => "ab093910-4584-0135-3efa-22000a984cfd",
                                "options_table" => "ab07eda0-4584-0135-3efa-22000a984cfd",
                                "options_text_column" => "ab07f080-4584-0135-3efa-22000a984cfd",
                                "options_identifier_column" => "ab07efd0-4584-0135-3efa-22000a984cfd"
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
                            ]
                        ],
                        "title" => "Make Report / Crear Reporte",
                        "description" => $company->name
                    ]
                ]
            );
        } catch (ClientException $e) {
            if($e->getResponse()->getStatusCode() == 404){
                $company->form_id = null;
                $company->save();
                return response()->json(['message' => 'Cannot update form that don\'t exitst. Please try again'], 404);
            }
        }
        return $this->updateGroup($company);
    }

    protected function updateGroup(Company $company)
    {
        if(!$company->form_id || !$company->group_id){
            return false;
        }
        $org_id = config('services.devicemagic.organization_id');
        $auth = 'Basic '.config('services.devicemagic.token');
        $response =  Guzzle::post(
            "https://www.devicemagic.com/organizations/{$org_id}/forms/{$company->form_id}/properties",
            [
                'headers' => [
                    'Authorization' => $auth,
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "group" => "PRS-{$company->name}-{$company->id}"
                ]
            ]
        );

        return ($response->getStatusCode() === 200);
    }


}
