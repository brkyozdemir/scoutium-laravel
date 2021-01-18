<?php

namespace App\Jobs;

use App\Mail\FirstEmail;
use App\Models\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $token;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('any_key')->allow(10)->every(60)->then(function () {
            $recipient = 'berkayozdemir02@gmail.com';
            Mail::to($recipient)->send(new FirstEmail($this->token));
            Log::info('Emailed token ' . $this->token);
        }, function () {
            // Could not obtain lock; this job will be re-queued
            return $this->release(10);
        });
    }
}
