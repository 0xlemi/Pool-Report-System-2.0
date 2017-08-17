<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\WorkOrder;
use App\User;
use App\PRS\Helpers\NotificationHelpers;
use Carbon\Carbon;
use Storage;
use App\UserRoleCompany;

class NewWorkOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $workOrder;
    protected $userRoleCompany;
    protected $helper;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WorkOrder $workOrder, UserRoleCompany $userRoleCompany, NotificationHelpers $helper)
    {
        $this->workOrder = $workOrder;
        $this->userRoleCompany = $userRoleCompany;
        $this->helper = $helper;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $workOrder = $this->workOrder;
        $loginSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(3)
        ]);
        $unsubscribeSigner = $this->userRoleCompany->urlSigners()->create([
            'token' => str_random(128),
            'expire' => Carbon::now()->addDays(10)
        ]);
        $person =  $this->helper->personStyled($this->userRoleCompany);
        $location = "workorders/{$workOrder->seq_id}";

        $image = Storage::url('images/assets/email/briefcase.png');
        if($this->workOrder->service->imageExists()){
            $image = Storage::url($this->workOrder->service->normalImage(1));
        }
        $start = $workOrder->start()->format('d M Y h:i:s A');

        $data = array(
                    'logo' => Storage::url('images/assets/app/logo-2.png'),
                    'objectImage' => $image,
                    'title' => "New WorkOrder Created!",
                    'moreInfo' => "The Work Order {$workOrder->name} is set to start at {$start} in your address {$workOrder->service->address_line}",
                    'magicLink' => url("/signin/{$loginSigner->token}?location={$location}"),
                    'unsubscribeLink' => url('/unsubscribe').'/'.$unsubscribeSigner->token,
                );

        return $this->subject('New WorkOrder Created')
                    ->view('emails.newObject')
                    ->with($data);
    }
}
