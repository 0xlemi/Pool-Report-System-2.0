<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\PRS\Classes\Logged;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view)    {
            if($user = auth()->user())
            {
                // Selected UserRoleCompany
                $selectedUser = $user->selectedUser;
                $view->with('selectedUser', collect([
                    'id' => $selectedUser->seq_id,
                    'company_name' => $selectedUser->company->name,
                    'icon' => $selectedUser->role->icon,
                ]));

                // List of Possible UserRoleCompanies for this User
                $urc = $user->userRoleCompanies()
                        ->join('companies', 'company_id', '=', 'companies.id')
                        ->join('roles', 'role_id', '=', 'roles.id')
                        ->select('companies.name as company_name',
                                'user_role_company.id as id',
                                'roles.name as role',
                                'text', 'icon')
                        ->get()->groupBy('company_name');
                $view->with('roles', $urc);

                $view->with('chat', (object)[
                    'id' => $selectedUser->chat_id,
                    'nickname' => $selectedUser->chat_nickname,
                    'token' => $selectedUser->chat_token,
                    'sound' => \Storage::url('sounds/chatNotification.mp3'),
                ]);
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
