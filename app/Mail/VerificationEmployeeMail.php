<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Company;
use App\UserRoleCompany;
use App\VerificationToken;

class VerificationEmployeeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $employee;
    public $company;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VerificationToken $token, UserRoleCompany $employee, Company $company)
    {
        $this->token = $token;
        $this->employee = $employee;
        $this->company = $company;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = [
            'name' => $this->employee->user->name,
            'role' => $this->employee->role->text,
            'company_name' => $this->company->name,
            'magicLink' => route('auth.activate', $this->token),
            'magicLinkWithBreaks' => wordwrap(route('auth.activate', $this->token), 50, '<br>', true)
        ];
        return $this->subject("{$this->company->name} is now using Pool Report System")
                ->view('emails.auth.welcomeActivationEmployee')
                ->with($data);
    }
}
