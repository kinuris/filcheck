<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Http;

class IncompleteMessageException extends Exception {}
class RequestMessageProblemException extends Exception {}
class NoPermissionMessageException extends Exception {}

class Message
{
    private string|int $orgId;
    private string $from;
    private string $message;
    private string $fullPhoneNumber;

    public static function filcheck(): self {
        $msg = new Message();
        $msg->setOrgId(16565);
        $msg->setFrom('FILCHECK');

        return $msg;
    } 

    public function setOrgId($orgId)
    {
        $this->orgId = $orgId;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setFullPhoneNumber($fullPhoneNumber)
    {
        $this->fullPhoneNumber = $fullPhoneNumber;
    }

    public function send()
    {
        if (empty($this->orgId) || empty($this->from) || empty($this->message) || empty($this->fullPhoneNumber)) {
            throw new IncompleteMessageException();
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'TOKEN ' . env('ENGAGESPARK_API_KEY'),
        ])->withBody([
            'orgId' => $this->orgId,
            'from' => $this->from,
            'message' => $this->message,
            'fullPhoneNumber' => $this->fullPhoneNumber
        ])->post('https://api.engagespark.com/v1/sms/phonenumber');

        $status = $response->status();
        if ($status === 400) {
            throw new RequestMessageProblemException();
        } else if ($status = 401) {
            throw new NoPermissionMessageException();
        }

        return $response->json();
    }
}
