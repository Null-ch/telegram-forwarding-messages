<?php

namespace App\Interfaces;

interface MessageHandlerInterface
{
    public function start(): void;
    public function stop(): void;
} 