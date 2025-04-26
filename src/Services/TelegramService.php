<?php

namespace App\Services;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;

class TelegramService
{
    private API $api;
    private int $myId;
    private int $targetId;

    public function __construct()
    {
        $settings = new Settings;
        $settings->getAppInfo()
            ->setApiId((int)$_ENV['TG_API_ID'])
            ->setApiHash($_ENV['TG_API_HASH']);

        $this->api = new API('session.madeline', $settings);
    }

    public function initialize(): void
    {
        $this->api->start();
        $me = $this->api->getSelf();
        $this->myId = $me['id'];

        $target = $this->api->getInfo($_ENV['TG_TARGET_USERNAME']);
        $this->targetId = $target['User']['id'];
    }

    public function getApi(): API
    {
        return $this->api;
    }

    public function getMyId(): int
    {
        return $this->myId;
    }

    public function getTargetId(): int
    {
        return $this->targetId;
    }

    public function sendMessage(string $message): void
    {
        $this->api->messages->sendMessage([
            'peer' => $this->targetId,
            'message' => $message
        ]);
    }
} 