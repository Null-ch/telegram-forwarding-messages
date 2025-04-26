# telegram-messages-forwarding

При добавлении в открытые (или закрытые) группы позволяет пересылать ВСЕ поступающие сообщения на указанный аккаунт

## Установка

1. Клонируйте репозиторий:
```bash
git clone https://github.com/Null-ch/telegram-messages-forwarding.git
cd telegram-messages-forwarding
```

2. Установите зависимости:
```bash
composer install
```

3. Скопируйте файл конфигурации:
```bash
cp .env.example .env
```

4. Отредактируйте `.env` файл, указав свои данные:
```
TG_API_ID=your_api_id
TG_API_HASH=your_api_hash
TG_TARGET_USERNAME=target_username
```

## Использование

Запустите бота:
```bash
php src/app.php
```

Бот будет:
- Авторизоваться в Telegram
- Отправлять приветственное сообщение указанному пользователю
- Слушать все входящие сообщения
- Пересылать новые сообщения указанному пользователю

Для завершения работы нажмите Ctrl+C.

## Структура проекта

```
├── src/
│   ├── Handlers/
│   │   └── MessageHandler.php
│   ├── Interfaces/
│   │   └── MessageHandlerInterface.php
│   ├── Services/
│   │   └── TelegramService.php
│   └── app.php
├── .env.example
├── .gitignore
├── composer.json
└── README.md
```

## Требования

- PHP 8.0 или выше
- Composer
- Telegram API credentials (api_id и api_hash)
