<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

use App\PRS\Traits\Controller\SettingsControllerTrait;

use JavaScript;
use Schema;

use DateTimeZone;
use DateTime;
use Auth;

use App\User;
use App\Administrator;
use App\Setting;

use App\Http\Requests;

class SettingsController extends PageController
{

    use SettingsControllerTrait;

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
    public function index()
    {
        $user = $this->getUser();
        $admin = $user->admin();

        $profile = (object)[
            'name' => $user->userable()->name,
            'lastName' => ($user->isAdministrator()) ? null : $user->userable()->last_name,
        ];
        $customization = (object)[
            'companyName' => $admin->company_name,
            'timezone' => $admin->timezone,
            'website' => $admin->website,
            'facebook' => $admin->facebook,
            'twitter' => $admin->twitter,
            'timezoneList' => $this->getTimezone(),
        ];
        $billing = (object)[
            'subscribed' => $admin->subscribed('main'),
            'lastFour' => $admin->card_last_four,
            'plan' => ($admin->subscribedToPlan('pro', 'main')) ? 'pro' : 'free',
            'activeObjects' => $admin->objectActiveCount(),
            'billableObjects' => $admin->billableObjects(),
            'freeObjects' => $admin->free_objects,
        ];
        $permissions = (object)[
            'supervisor' => $admin->permissions()->permissionsDivided('sup'),
            'technician' => $admin->permissions()->permissionsDivided('tech'),
        ];

        $timezones = $this->getTimezone();

        return view('settings.index', compact('profile', 'customization', 'billing', 'permissions'));
    }

    public function profile(Request $request)
    {

        // check permissions

        $this->validate($request, [
            'name' => 'required|string|max:50',
            'last_name' => 'string|max:50',
        ]);

        $object = $request->user()->userable();

        if($object->update(array_map('htmlentities', $request->only(['name', 'last_name'])))){
            return $this->respondWithSuccess('Profile settings was updated successfully.');
        }
        return $this->respondInternalError('Profile settings was not updated, Please try again later.');
    }

    public function changeEmail(Request $request){

        // check permissions

        $user = $this->getUser();
        $this->validate($request, [
            'old_password' => 'required|string|max:255',
            'new_email' => 'required|email|max:255|unique:users,email,'.$user->userable_id.',userable_id',
        ]);

        if($user->checkPassword($request->old_password)){
            $user->email = htmlentities($request->new_email);
            if($user->save()){
                return $this->respondWithSuccess('Email was updated');
            }
            return $this->respondInternalError('Email was not updated, there was an error.');
        }
        return $this->respondWithValidationError('Email was not updated, the information is wrong');
    }

    public function changePassword(Request $request){

        // check permissions

        if($this->getUser()->cannot('changePassword', Setting::class))
        {
            return $this->setStatusCode(403)->respondWithError('You don\'t have permission to access this.');
        }

        $this->validate($request, [
          'old_password' => 'required|string|max:255',
          'new_password' => 'required|string|between:6,255',
          'confirm_password' => 'required|string|between:6,255|same:new_password',
        ]);

            $user = $this->getUser();
            if($user->checkPassword($request->old_password)){
                $user->password = bcrypt($request->new_password);
                if($user->save()){
                    return $this->respondWithSuccess('Password was updated');
                }
            return $this->respondInternalError('Password not updated, there was an error.');
         }
         return $this->respondWithValidationError('Password not updated , the information is wrong');
    }

    public function customization(Request $request){

        // check permissions

        $this->validate($request, [
            'company_name' => 'required|string|between:2,30',
            'timezone' => 'required|string|validTimezone',
            'website' => 'regex:/^([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'facebook' => 'string|max:50',
            'twitter' => 'string|max:15',
        ]);

        $admin = $this->loggedUserAdministrator();

        $saved = $admin->update(array_map('htmlentities', $request->only([
            'company_name',
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

    public function notifications(Request $request)
    {
        //
        // $this->validate($request, [
        //     'id' => [
        //         'required',
        //         'max:255',
        //         'regex:/\w+\_\w+\_\w+/',
        //         ],
        // ]);
        //
        // $person = $this->getUser()->userable();
        // $attributes = $person->getAttributes();
        //
        // $columnName = $request->id;
        // $checked_value = strtolower($request->checked);
        // $checked = ($checked_value  == 'true' || $checked_value  == '1') ? true : false;
        //
        // //check whether the id they are sending us is a real email preference
        // if(isset($attributes[$columnName]))
        // {
        //     $person->$columnName = $checked;
        //     if($person->save()){
        //         $checkedAfter = ($person->$columnName) ? 'active' : 'inactive';
        //         return $this->respondWithSuccess('Permission has been changed to: '.$checkedAfter);
        //     }
        //     return $this->respondInternalError('Error while persisting the permission');
        // }
        // return $this->respondNotFound('There is no permission with that id');


    }

    public function subscribe(Request $request)
    {
        $user = Auth::user();
        if(!$user->isAdministrator()){
            return response()->json(['message' => 'You are not logged in as administrator'], 422);
        }
        $admin = $user->userable();

        // Admin is upgrading the credit card.
        if ($admin->subscribed('main')) {
            return $this->updateCreditCard($admin, $request->stripeToken);
        }

        // Admin is subscribing for the first time
        $result = $admin->newSubscription('main', 'pro')
                    ->create($request->stripeToken)
                    ->updateQuantity($admin->billableObjects());
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

    private function updateCreditCard(Administrator $admin, string $stripeToken)
    {
        $admin->updateCard($stripeToken);
        $result = $admin->subscription('main')
                    ->updateQuantity($admin->billableObjects());

        if($result){
            flash()->overlay('Credit Card Changed', 'Your credit card was updated successfully.', 'success');
            return redirect()->back();
        }
        flash()->overlay('Error changing credit card',
                'Send us an email to support@poolreprotsystem to change your credit card manualy.',
                'error');
        return redirect()->back();
    }

    public function upgradeSubscription()
    {
        $user = Auth::user();
        if(!$user->isAdministrator()){
            return response()->json(['message' => 'You are not logged in as administrator'], 422);
        }
        $admin = $user->userable();

        if($admin->subscribedToPlan('free', 'main')) {
            return $admin->subscription('main')
                            ->swap('pro');
        }elseif($admin->subscribedToPlan('pro', 'main')){
            return response()->json(['error' => 'You cannot upgrade if you are on pro subscription.'], 422);
        }

    }

    public function downgradeSubscription()
    {
        $user = Auth::user();
        if(!$user->isAdministrator()){
            return response()->json(['message' => 'You are not logged in as administrator'], 422);
        }
        $admin = $user->userable();

        if ($admin->subscribedToPlan('pro', 'main')) {
            $result = $admin->subscription('main')->swap('free');
            if($result){
                return (string) $admin->setBillibleUsersAsInactive();
            }
        }elseif($admin->subscribedToPlan('free', 'main')){
            return response()->json(['error' => 'You cannot downgrade if you are on free subscription.'], 422);
        }
        // return response()->json(['error' => 'You cannot downgrade if you are on free subscription.'], 422);
    }

    private function getTimezone()
    {
        $regions = array(
            'Africa' => DateTimeZone::AFRICA,
            'America' => DateTimeZone::AMERICA,
            'Antarctica' => DateTimeZone::ANTARCTICA,
            'Aisa' => DateTimeZone::ASIA,
            'Atlantic' => DateTimeZone::ATLANTIC,
            'Europe' => DateTimeZone::EUROPE,
            'Indian' => DateTimeZone::INDIAN,
            'Pacific' => DateTimeZone::PACIFIC
        );
        $timezones = array();
        foreach ($regions as $name => $mask)
        {
            $zones = DateTimeZone::listIdentifiers($mask);
            foreach($zones as $timezone)
            {
        		// Lets sample the time there right now
        		$time = new DateTime(NULL, new DateTimeZone($timezone));
        		// Us dumb Americans can't handle millitary time
        		$ampm = $time->format('H') > 12 ? ' ('. $time->format('g:i a'). ')' : '';
        		// Remove region name and add a sample time
        		$timezones[$name][$timezone] = substr($timezone, strlen($name) + 1) . ' - ' . $time->format('H:i') . $ampm;
        	}
        }
        return $timezones;
    }



}
