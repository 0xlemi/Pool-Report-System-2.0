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
            if($user = Logged::user())
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
                        ->get()->transform(function ($item) {
                            $role = $item->role;
                            return collect( [
                                'id' => $item->id,
                                'company_name' => $item->company->name,
                                'role' => $role->name,
                                'text' => $role->text,
                                'icon' => $role->icon
                            ]);
                        })->groupBy('company_name');
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
