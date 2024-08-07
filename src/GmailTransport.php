<?php

namespace AD5jp\LaravelGmail;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;

class GmailTransport extends Transport
{
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $client = new Client();
        $client->setApplicationName(config('app.name'));
        $client->setAuthConfig(base_path(config('gmail.service_account_key')));
        $client->setScopes([Gmail::GMAIL_SEND]);
        $client->setSubject(config('gmail.from_address'));

        $service = new Gmail($client);

        $gmail_message = new Message();
        $gmail_message->setRaw(base64_encode($message->toString()));

        $service->users_messages->send(config('gmail.from_address'), $gmail_message);

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }
}
