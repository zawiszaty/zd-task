<?php

namespace App\Jobs;

use App\Mail\ForgotPassword;
use App\Models\ResetCodePassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendForgotPasswordMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $email)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ResetCodePassword::where('email', $this->email)->delete();

        $data['code'] = mt_rand(100000, 999999);
        $data['email'] = $this->email;
        $data['created_at'] = new \DateTime();

        $codeData = ResetCodePassword::create($data);

        Mail::to($this->email)->send(new ForgotPassword($codeData->code));
    }
}
