<?php

require 'vendor/autoload.php';

use App\Handlers\MessageHandler;
use App\Services\TelegramService;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

try {
    $telegramService = new TelegramService();
    $telegramService->initialize();
    
    echo "Авторизация успешна!\n";

    $telegramService->sendMessage("Бот запущен и готов к работе!");
    echo "Приветственное сообщение отправлено\n";
    
    $handler = new MessageHandler($telegramService);
    $handler->start();
    
} catch (\Throwable $e) {
    echo "Произошла ошибка: " . $e->getMessage() . "\n";
} 