<?php

namespace AD5jp\LaravelGmail;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;

class GmailTransport extends Transport
{
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $client = new Google_Client();
        $client->setApplicationName(config('app.name'));
        $client->setAuthConfig(base_path(config('gmail.service_account_key')));
        $client->setScopes([Google_Service_Gmail::GMAIL_SEND]);
        $client->setSubject(config('gmail.from_address'));

        $service = new Google_Service_Gmail($client);

        $gmail_message = new Google_Service_Gmail_Message();
        $gmail_message->setRaw(base64_encode($message->toString()));

        $service->users_messages->send(config('gmail.from_address'), $gmail_message);

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }
}
