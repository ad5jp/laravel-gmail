<?php

namespace AD5jp\LaravelGmail;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Mail\Transport\Transport;
use Swift_Mime_SimpleMessage;

class GmailTransport extends Transport
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
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $service = new Gmail($this->client);

        $gmail_message = new Message();
        $gmail_message->setRaw(base64_encode($message->toString()));

        $service->users_messages->send($this->config['from_address'], $gmail_message);

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }
}
