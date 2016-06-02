<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class ServiceApiTest extends ApiTester
{


    /** @test */
    public function check_if_user_is_been_authentificated_if_not_throws_a_403()
    {
        $user = factory(User::class)->create();

        $services = factory(App\Service::class, 2)->create();

        $this->json('GET', '/api/v1/services');

        $this->assertResponseStatus(401);

        $this->json('GET', '/api/v1/services', [
            'api_token' => $user->api_token,
        ]);

        $this->assertResponseOk();


    }


    /** @test */
    public function get_all_services_list()
    {

        $user = factory(User::class)->create();

        $services = factory(App\Service::class, 3)->create();

        $this->json('GET', '/api/v1/services', [
            'api_token' => $user->api_token,
        ])->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'address_line',
                    'city',
                    'state',
                    'postal_code',
                    'country',
                    'type',
                    'service_day_monday',
                    'service_day_tuesday',
                    'service_day_wednesday',
                    'service_day_thursday',
                    'service_day_friday',
                    'service_day_saturday',
                    'service_day_sunday',
                    'amount',
                    'currency',
                    'start_time',
                    'end_time',
                    'status',
                    'comments',
                    'icon_photo',
                    'thumbnail_photo',
                    'normal_photo',
                ]
            ]
        ]);

      $this->assertResponseOk();
    }

    /** @test */
    public function user_can_create_new_service()
    {
        $user = factory(User::class)->create();

        $this->json('POST', '/api/v1/services',[
            'api_token' => $user->api_token,
            'name'  => 'Casa bonita',
            'address_line' => 'Cangrejos 123',
            'city' => 'San Jose del Cabo',
            'state' => 'Baja California Sur',
            'postal_code' => '23400',
            'country' => 'MX',
            'type' => 2,
            'service_day_monday' => 1,
            'service_day_tuesday' => 0,
            'service_day_wednesday' => 1,
            'service_day_thursday' => 0,
            'service_day_friday' => 1,
            'service_day_saturday' => 0,
            'service_day_sunday' => 0,
            'amount' => '350',
            'currency' => 'usd',
            'start_time' => '5:20',
            'end_time' => '14:35',
            'status' => 1,
            'comments' => 'This are the test comments',
        ])->seeJson([
            "message" => "The service was successfuly created.",
            // "object" => [
            //     "id" => null,
            //     // 'name'  => 'Casa bonita',
            //     // 'address_line' => 'Cangrejos 123',
            //     // 'city' => 'San Jose del Cabo',
            //     // 'state' => 'Baja California Sur',
            //     // 'postal_code' => '23400',
            //     // 'country' => 'MX',
            //     // 'type' => 2,
            //     // // 'service_day_monday' => true,
            //     // // 'service_day_tuesday' => false,
            //     // // 'service_day_wednesday' => true,
            //     // // 'service_day_thursday' => false,
            //     // // 'service_day_friday' => true,
            //     // // 'service_day_saturday' => false,
            //     // // 'service_day_sunday' => false,
            //     // 'amount' => '350',
            //     // 'currency' => 'usd',
            //     // 'start_time' => '5:20',
            //     // 'end_time' => '14:35',
            //     // 'status' => true,
            //     // 'comments' => 'This are the test comments',
            //     // "icon_photo" => "img/avatar-2-48.png",
            //     // "thumbnail_photo" => "img/no_image.png",
            //     // "normal_photo" => "img/no_image.png"
            // ]
        ]);



    }



}
