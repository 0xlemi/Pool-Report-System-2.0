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
    public function checkIfItHasPermissinGivenTheNameAndType()
    {
        // Given
        $mockUser = Mockery::mock(App\User::class);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_0')->andReturn(0);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_1')->andReturn(1);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_2')->andReturn(2);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_3')->andReturn(3);
        $name0 = 'notify_random_0';
        $name1 = 'notify_random_1';
        $name2 = 'notify_random_2';
        $name3 = 'notify_random_3';
        $type0 = 'database';
        $type1 = 'mail';

        // When
        $userHelpers = new UserHelpers;
        $false1 = $userHelpers->hasPermission($mockUser, $name0, 'database');
        $false2 = $userHelpers->hasPermission($mockUser, $name0, 'mail');
        $true1 = $userHelpers->hasPermission($mockUser, $name1, 'database');
        $false3 = $userHelpers->hasPermission($mockUser, $name1, 'mail');
        $false4 = $userHelpers->hasPermission($mockUser, $name2, 'database');
        $true2 = $userHelpers->hasPermission($mockUser, $name2, 'mail');
        $true3 = $userHelpers->hasPermission($mockUser, $name3, 'database');
        $true4 = $userHelpers->hasPermission($mockUser, $name3, 'mail');

        // Then
        $this->assertTrue($true1);
        $this->assertTrue($true2);
        $this->assertTrue($true3);
        $this->assertTrue($true4);
        $this->assertFalse($false1);
        $this->assertFalse($false2);
        $this->assertFalse($false3);
        $this->assertFalse($false4);
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
    public function getNotificationPermissionFinalDatabaseNumberFromNotifacationChangeVariables()
    {
        // Given
        $mockUser = Mockery::mock(App\User::class);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_0')->andReturn(0);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_1')->andReturn(1);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_2')->andReturn(2);
        $mockUser->shouldReceive('getAttribute')->with('notify_random_3')->andReturn(3);
        $name0 = 'notify_random_0';
        $name1 = 'notify_random_1';
        $name2 = 'notify_random_2';
        $name3 = 'notify_random_3';
        $type0 = 'database';
        $type1 = 'mail';

        // When
        $userHelpers = new UserHelpers;
        $zero_1 = $userHelpers->notificationChanged($mockUser, $name0, 'mail', false);
        $one_1 = $userHelpers->notificationChanged($mockUser, $name0, 'database', true);
        $one_2 = $userHelpers->notificationChanged($mockUser, $name3, 'mail', false);
        $two_1 = $userHelpers->notificationChanged($mockUser, $name0, 'mail', true);
        $two_2 = $userHelpers->notificationChanged($mockUser, $name3, 'database', false);
        $three_1 = $userHelpers->notificationChanged($mockUser, $name1, 'mail', true);
        $three_2 = $userHelpers->notificationChanged($mockUser, $name3, 'database', true);

        // Then
        $this->assertEquals(0, $zero_1);
        $this->assertEquals(1, $one_1);
        $this->assertEquals(1, $one_2);
        $this->assertEquals(2, $two_1);
        $this->assertEquals(2, $two_2);
        $this->assertEquals(3, $three_1);
        $this->assertEquals(3, $three_1);

    }

}
