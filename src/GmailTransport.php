<?php

namespace AD5jp\LaravelGmail;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;

class GmailTransport extends AbstractTransport
{
    protected $client;

    public function __construct()
    {
        $client = new Client();
        $client->setApplicationName(config('app.name'));
        $client->setAuthConfig(base_path(config('gmail.service_account_key')));
        $client->setScopes([Gmail::GMAIL_SEND]);
        $client->setSubject(config('gmail.from_address'));

        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $service = new Gmail($this->client);

        $gmail_message = new Message();
        $gmail_message->setRaw(base64_encode($message->getOriginalMessage()->toString()));

        $service->users_messages->send(config('gmail.from_address'), $gmail_message);
    }

    public function __toString(): string
    {
        return 'gmail';
    }
}
