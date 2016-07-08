<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;

class UserApiTest extends ApiTester
{


  // /** @test */
  // public function fails_if_authorisation_was_not_met()
  // {
  //   $this->json('GET', '/api/v1/user');
  //
  //   $this->assertResponseStatus(401);
  // }


  // /** @test */
  // public function gets_logged_user_information()
  // {
  //
  //   $user = factory(User::class)->create();
  //
  //   $this->json('GET','/api/v1/user', [
  //           'api_token' => $user->api_token,
  //        ])->seeJsonEquals([
  //           'name' => $user->name,
  //       	'email' => $user->email,
  //           'company_name' => $user->company_name,
  //           'website' => $user->website,
  //           'facebook' => $user->facebook,
  //           'twitter' => $user->twitter,
  //       	'language' => $user->language,
  //       	'timezone' => $user->timezone,
  //        ])->dontSeeJson([
  //           'api_token' => $user->api_token,
  //           'remember_token' => $user->remember_token,
  //           'deleted_at' => $user->deleted_at,
  //           'created_at' => $user->created_at,
  //           'password' => $user->password,
  //        ]);
  //
  //   $this->assertResponseOk();
  // }



}
