<?php

namespace HippoBaguette\ChatFilter;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use pocketmine\Player;

class ChatFlaggedEvent extends Event implements Cancellable
{
    public Player $player;
    public string $message;

    public function __construct(Player $player, string $message)
    {
        $this->player = $player;
        $this->message = $message;
    }
    public function getPlayer(): Player {
        return $this->player;
    }
    public function getMessage(): string {
        return $this->message;
    }
}