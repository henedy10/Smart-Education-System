<?php

namespace App\Services\OTP;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioService
{
    public function send()
    {

        $sid = env('TWILIO_ACCOUNT_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                '+20 10 90346842',
                [
                    'from' => env('TWILIO_PHONE_NUMBER'),
                    'body' => 'Your OTP Code is 1234',
                ]
            );
        } catch (TwilioException $e) {
            Log::alert($e->getMessage());
        }
    }
}
