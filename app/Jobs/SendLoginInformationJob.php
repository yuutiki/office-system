<?php

namespace App\Jobs;

use App\Mail\SendLoginInformation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLoginInformationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    private $email;
    private $password;
    private $locale;
 
    /**
     * Create a new job instance.
     */
    public function __construct($url, $email, $password, $locale = 'ja')
    {
        $this->url = $url;
        $this->email = $email;
        $this->password = $password;
        $this->locale = $locale;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new SendLoginInformation($this->url, $this->email, $this->password, $this->locale));        
    }
}
