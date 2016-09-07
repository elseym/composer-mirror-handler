<?php

namespace Elseym\MirrorHandler;

use Composer\Script\Event;

interface EventHandlerInterface
{
    public static function handle(Event $event);
}
