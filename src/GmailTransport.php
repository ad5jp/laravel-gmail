<?php

namespace AD5jp\LaravelGmail;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;

class GmailTransport extends AbstractTransport
{
    protected $config;
    protected $client;

    public function __construct(array $config)
    {
        $this->config = $config;

        $this->client = new Client();
        $this->client->setApplicationName(config('app.name'));
        $this->client->setAuthConfig(base_path($this->config['service_account_key']));
        $this->client->setScopes([Gmail::GMAIL_SEND]);
        $this->client->setSubject($this->config['from_address']);

        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        $service = new Gmail($this->client);

        $gmail_message = new Message();
        $gmail_message->setRaw(base64_encode($message->getOriginalMessage()->toString()));

        $service->users_messages->send($this->config['from_address'], $gmail_message);
    }

    public function __toString(): string
    {
        return 'gmail';
    }
}
