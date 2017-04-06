<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\PRS\Helpers\UserHelpers;

class UserHelpersTest extends TestCase
{

    /** @test */
    public function checkArrayPositionGivenTheNotificationType()
    {
        // 'notificationTypes' => [
        //     'database' => "font-icon font-icon-alarm",
        //     'mail' => "font-icon font-icon-mail",
        // ]
        // Given
        $firstType = 'database';
        $secondType = 'mail';

        // When
        $userHelpers = new UserHelpers;
        $first = $userHelpers->notificationTypePosition($firstType);
        $second = $userHelpers->notificationTypePosition($secondType);

        // Then
        $this->assertEquals($first, 0);
        $this->assertEquals($second, 1);
    }

    /** @test */
    public function getNotficationPermissionsNumberFromArray()
    {
        // Given
        $binary_0 = [0, 0];
        $binary_1 = [1, 0];
        $binary_2 = [0, 1];
        $binary_3 = [1, 1];
        $binary_4 = [0, 0, 1];
        $binary_5 = [1, 0, 1];
        $binary_6 = [0, 1, 1];
        $binary_7 = [1, 1, 1];

        // When
        $userHelpers = new UserHelpers;
        $decimal_0 = $userHelpers->notificationPermissionToNum($binary_0);
        $decimal_1 = $userHelpers->notificationPermissionToNum($binary_1);
        $decimal_2 = $userHelpers->notificationPermissionToNum($binary_2);
        $decimal_3 = $userHelpers->notificationPermissionToNum($binary_3);
        $decimal_4 = $userHelpers->notificationPermissionToNum($binary_4);
        $decimal_5 = $userHelpers->notificationPermissionToNum($binary_5);
        $decimal_6 = $userHelpers->notificationPermissionToNum($binary_6);
        $decimal_7 = $userHelpers->notificationPermissionToNum($binary_7);

        // Then
        $this->assertEquals(0, $decimal_0);
        $this->assertEquals(1, $decimal_1);
        $this->assertEquals(2, $decimal_2);
        $this->assertEquals(3, $decimal_3);
        $this->assertEquals(4, $decimal_4);
        $this->assertEquals(5, $decimal_5);
        $this->assertEquals(6, $decimal_6);
        $this->assertEquals(7, $decimal_7);

    }

    /** @test */
    public function getNotificationPermissionsArrayFromNumber()
    {
        // Given
        // When
        $userHelpers = new UserHelpers;
        $array_0 = $userHelpers->notificationPermissonToArray(0);
        $array_1 = $userHelpers->notificationPermissonToArray(1);
        $array_2 = $userHelpers->notificationPermissonToArray(2);
        $array_3 = $userHelpers->notificationPermissonToArray(3);
        $array_4 = $userHelpers->notificationPermissonToArray(4);
        $array_5 = $userHelpers->notificationPermissonToArray(5);
        $array_6 = $userHelpers->notificationPermissonToArray(6);
        $array_7 = $userHelpers->notificationPermissonToArray(7);

        // Then
        $this->assertEquals([0, 0], $array_0);
        $this->assertEquals([1, 0], $array_1);
        $this->assertEquals([0, 1], $array_2);
        $this->assertEquals([1, 1], $array_3);
        $this->assertEquals([0, 0, 1], $array_4);
        $this->assertEquals([1, 0, 1], $array_5);
        $this->assertEquals([0, 1, 1], $array_6);
        $this->assertEquals([1, 1, 1], $array_7);


    }


}
