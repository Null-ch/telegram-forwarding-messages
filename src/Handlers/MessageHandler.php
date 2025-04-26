<?php

namespace App\Handlers;

use App\Interfaces\MessageHandlerInterface;
use App\Services\TelegramService;

class MessageHandler implements MessageHandlerInterface
{
    private TelegramService $telegramService;
    private bool $running = true;
    private int $offset = 0;

    public function __construct(TelegramService $telegramService)
    {
        $this->telegramService = $telegramService;

        pcntl_signal(SIGINT, function() {
            $this->stop();
        });
    }

    public function start(): void
    {
        echo "Начинаю слушать обновления...\n";
        echo "Для завершения работы нажмите Ctrl+C\n";

        while ($this->running) {
            try {
                $updates = $this->telegramService->getApi()->getUpdates([
                    'offset' => $this->offset,
                    'limit' => 50,
                    'timeout' => 1
                ]);

                if (count($updates) > 0) {
                    foreach ($updates as $update) {
                        $this->offset = $update['update_id'] + 1;
                        
                        if (isset($update['update'])) {
                            $this->handleUpdate($update['update']);
                        }
                    }
                }

                pcntl_signal_dispatch();
            } catch (\Throwable $e) {
                echo "Ошибка при обработке обновлений: " . $e->getMessage() . "\n";
            }
            sleep(1);
        }

        echo "Работа завершена\n";
    }

    public function stop(): void
    {
        echo "\nПолучен сигнал завершения. Завершаю работу...\n";
        $this->running = false;
    }

    private function handleUpdate(array $updateData): void
    {
        if ($updateData['_'] === 'updateNewMessage' || $updateData['_'] === 'updateNewChannelMessage') {
            $message = $updateData['message'];
            
            if (isset($message['from_id']) && $message['from_id'] == $this->telegramService->getMyId()) {
                return;
            }

            if (isset($message['message'])) {
                try {
                    $this->telegramService->sendMessage("Новое сообщение: " . $message['message']);
                } catch (\Throwable $e) {
                    echo "Ошибка при отправке сообщения: " . $e->getMessage() . "\n";
                }
            }
        }
    }
} 