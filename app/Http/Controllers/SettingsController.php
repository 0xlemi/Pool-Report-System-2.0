<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

use App\PRS\Traits\Controller\SettingsControllerTrait;
use App\PRS\Helpers\UserHelpers;

use JavaScript;
use Schema;

use DateTimeZone;
use DateTime;
use Auth;

use App\User;
use App\Setting;
use App\Company;

use App\Http\Requests;
use App\NotificationSetting;

class SettingsController extends PageController
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * The settings view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $userRoleCompany = $user->selectedUser;
        $company = $this->loggedCompany();

        $profile = null;
        if ($user->can('profile', Setting::class)) {
            $profile = (object)[
                'name' => $user->name,
                'lastName' => $user->last_name,
                'email' => $user->email,
                'deleteIcon' => \Storage::url('images/assets/app/exclamation-mark.png'),
            ];
        }

        $customization = null;
        if ($user->can('customization', Setting::class)) {
            $customization = (object)[
                'name' => $company->name,
                'timezone' => $company->timezone,
                'website' => $company->website,
                'facebook' => $company->facebook,
                'twitter' => $company->twitter,
                'timezoneList' => timezoneList(),
            ];
        }

        $notifications = null;
        if ($user->can('notifications', Setting::class)) {
            $notifications = (object)[
                'settings' => $user->selectedUser->allNotificationSettings(),
            ];
        }

        $billing = null;
        if ($user->can('billing', Setting::class)) {
            $billing = (object)[
                'subscribed' => $company->subscribed('main'),
                'lastFour' => $company->card_last_four,
                'plan' => ($company->subscribedToPlan('pro', 'main')) ? 'pro' : 'free',
                'activeObjects' => $company->objectActiveCount(),
                'billableObjects' => $company->billableObjects(),
                'freeObjects' => $company->free_objects,
            ];
        }

        $permissions = null;
        if ($user->can('permissions', Setting::class)) {
            $permissions = (object)[
                'supervisor' => $company->allPermissions('sup'),
                'technician' => $company->allPermissions('tech'),
            ];
        }

        return view('settings.index', compact('profile', 'customization', 'notifications', 'billing', 'permissions'));
    }

    public function profile(Request $request)
    {
        $this->authorize('profile', Setting::class);

        $this->validate($request, [
            'name' => 'required|string|max:50',
            'last_name' => 'string|max:50',
        ]);

        $object = $request->user();

        if($object->update(array_map('htmlentities', $request->only(['name', 'last_name'])))){
            return $this->respondWithSuccess('Profile settings was updated successfully.');
        }
        return $this->respondInternalError('Profile settings was not updated, Please try again later.');
    }

    public function changeEmail(Request $request)
    {
        $this->authorize('changeEmail', Setting::class);

        $user = $request->user();
        $this->validate($request, [
            'password' => 'required|string|max:200',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id.',id',
        ]);

        if($user->checkPassword($request->password)){
            $user->email = htmlentities($request->email);
            if($user->save()){
                return response('Email was updated');
            }
            return response('Email was not updated, there was an error.', 500);
        }
        // avoid password fishing
        sleep(2);
        return response('Email was not updated, the password is wrong', 400);
    }

    public function changePassword(Request $request)
    {
        $this->authorize('changePassword', Setting::class);

        $this->validate($request, [
          'oldPassword' => 'required|string|between:6,200',
          'newPassword' => 'required|alpha_dash|between:6,200',
          'confirmPassword' => 'required|alpha_dash|between:6,200|same:newPassword',
        ]);

        $user = $request->user();
        if($user->checkPassword($request->oldPassword)){
            $user->password = bcrypt($request->newPassword);
            if($user->save()){
                return response('Password was updated');
            }
            return response('Password was not updated, there was an error.', 500);
         }
        sleep(3); // avoid password fishing
        return response('Password was not updated, the password is wrong', 400);
    }

    public function deleteAccount(Request $request)
    {
        $this->authorize('deleteAccount', Setting::class);

        $this->validate($request, [
          'password' => 'required|string|max:200',
        ]);

        $user = $request->user();
        if(!$user->checkPassword($request->password)){
            sleep(3); // avoid password fishing
            return response()->json([
                'error' => 'Account not deleted, the password is wrong.'
            ], 400);
        }

        $object = $user->userable();
        if($object->delete()){
            \Auth::logout();
            $request->session()->flash('info', 'Your account has been completely deleted!');
            return response()->json([
                'message' => 'Your account has been completely deleted.'
            ]);
        }
        return response()->json([
                'error' => 'The account was not deleted, please contact support@poolreportsystem.com.'
            ], 500);

    }

    public function customization(Request $request)
    {
        $this->authorize('customization', Setting::class);

        $this->validate($request, [
            'name' => 'required|string|between:2,30',
            'timezone' => 'required|string|validTimezone',
            'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'facebook' => 'string|max:50',
            'twitter' => 'string|max:15',
        ]);

        $company = $this->loggedCompany();
        $saved = $company->update(array_map('htmlentities', $request->only([
            'name',
            'language',
            'timezone',
            'website',
            'facebook',
            'twitter',
        ])));

        if($saved){
            return $this->respondWithSuccess('Company information was updated successfully.');
        }
        return $this->respondInternalError('Company information was not updated, Please try again later.');

    }

    public function notifications(Request $request, UserHelpers $userHelper)
    {
        $this->authorize('notifications', Setting::class);

        $this->validate($request, [
            'name' => 'required|string|max:255|validNotification',
            'type' => 'required|string|max:20|validNotificationType:name',
            'value' => 'required|boolean'
        ]);

        $userRoleCompany = $request->user()->selectedUser;
        $name = $request->name;
        $type = $request->type;
        $notificationSetting = NotificationSetting::where('name', $name)->where('type', $type)->firstOrFail();
        $value = !$request->value; // the value is backwards

        if($value){
            if(!$userRoleCompany->hasNotificationSetting($name, $type)){
                $userRoleCompany->notificationSettings()->attach($notificationSetting->id);
            }
        }else{
            if($userRoleCompany->hasNotificationSetting($name, $type)){
                $userRoleCompany->notificationSettings()->detach($notificationSetting->id);
            }
        }

        return $this->respondWithSuccess("Notification {$name} has been changed to: {$value}");
    }

    public function permissions(Request $request)
    {
        $this->authorize('permissions', Setting::class);

        $this->validate($request, [
            'id' => 'required|max:255|validPermission',
            'checked' => 'required',
        ]);

        $admin = $this->loggedUserAdministrator();
        $attributes = $admin->getAttributes();

        $columnName = $request->id;
        $checkedValue = strtolower($request->checked);
        $checked = ($checkedValue  == 'true' || $checkedValue  == '1') ? true : false;

        //check whether the id they are sending us is a real permission
        if(isset($attributes[$columnName]))
        {
            $admin->$columnName = $checked;
            if($admin->save()){
                $checkedAfter = ($admin->$columnName) ? 'active' : 'inactive';
                return $this->respondWithSuccess('Permission has been changed to: '.$checkedAfter);
            }
            return $this->respondInternalError('Error while persisting the permission');
        }
        return $this->respondNotFound('There is no permission with that id');
    }

    // *******************
    //     BIllable
    // *******************

    public function subscribe(Request $request)
    {
        $this->authorize('billing', Setting::class);

        $company = $this->loggedCompany();

        // Admin is upgrading the credit card.
        if ($company->subscribed('main')) {
            return $this->updateCreditCard($company, $request->stripeToken);
        }

        // Admin is subscribing for the first time
        $result = $company->newSubscription('main', 'pro')
                    ->create($request->stripeToken)
                    ->updateQuantity($company->billableObjects());
        if($result){
            flash()->overlay('Upgraded to Pro',
                    'You are now free to add as much technicians and supervisors as you need.',
                    'success');
            return redirect()->back();
        }
            flash()->overlay('Error upgrading to Pro',
                    'Send us an email to support@poolreprotsystem to upgrade you manualy.',
                    'error');
            return redirect()->back();
    }

    private function updateCreditCard(Company $company, string $stripeToken)
    {
        $company->updateCard($stripeToken);
        $result = $company->subscription('main')
                    ->updateQuantity($company->billableObjects());

        if($result){
            flash()->overlay('Credit Card Changed', 'Your credit card was updated successfully.', 'success');
            return redirect()->back();
        }
        flash()->overlay('Error changing credit card',
                'Send us an email to support@poolreprotsystem to change your credit card manualy.',
                'error');
        return redirect()->back();
    }

    public function upgradeSubscription(Request $request)
    {
        $this->authorize('billing', Setting::class);

        $company = $this->loggedCompany();

        if($company->subscribedToPlan('free', 'main')) {
            return $company->subscription('main')
                            ->swap('pro')
                            ->updateQuantity($company->billableObjects());
        }elseif($company->subscribedToPlan('pro', 'main')){
            return response()->json(['error' => 'You cannot upgrade if you are on pro subscription.'], 422);
        }

    }

    public function downgradeSubscription(Request $request)
    {
        $this->authorize('billing', Setting::class);

        $company = $this->loggedCompany();

        if ($company->subscribedToPlan('pro', 'main')) {
            $result = $company->subscription('main')->swap('free');
            if($result){
                return (string) $company->setBillibleUsersAsInactive();
            }
        }elseif($company->subscribedToPlan('free', 'main')){
            return response()->json(['error' => 'You cannot downgrade if you are on free subscription.'], 422);
        }
    }

}
