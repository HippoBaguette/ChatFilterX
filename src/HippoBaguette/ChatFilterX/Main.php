<?php

namespace HippoBaguette\ChatFilterX;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class Main extends PluginBase implements Listener
{
    private string $action;
    private Config $config;

    public function onEnable()
    {
        if (!is_file($this->getDataFolder() . "config.yml")) {
            $this->saveDefaultConfig();
        }

        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        if (!is_dir($this->getDataFolder())) {
            @mkdir($this->getDataFolder());
        }

        $this->action = $this->config->get("flagged-words");
    }

    public function onChat(PlayerChatEvent $event)
    {
        if ($event->getPlayer()->hasPermission("chatfilter.bypass")) {
            return;
        }
        if ($event->getPlayer()->isOp()) {
            return;
        }
        if ($this->action == "send") {
            return;
        }

        if ($this->action == "filter") {
            $message = $event->getMessage();
            $event->setMessage(str_ireplace($this->config->get("filter-words"), "", $event->getMessage()));
            if ($this->config->get("message-toggle") === true && $event->getMessage() != $message) {
                $event->getPlayer()->sendMessage(TextFormat::RED . $this->config->get("message")); 
                $chatFlagEvent = new ChatFlaggedEvent($event->getPlayer(), $event->getMessage());
                $chatFlagEvent->call();
            }
        }
        if ($this->action == "block") {
            foreach ($this->config->get("filter-words") as $word) {
                if (strpos(strtolower($event->getMessage()), strtolower($word)) !== false) {
                    $event->setCancelled();
                    if ($this->config->get("message-toggle") === true) {
                        $event->getPlayer()->sendMessage(TextFormat::RED . $this->config->get("message"));
                    }
                    $chatFlagEvent = new ChatFlaggedEvent($event->getPlayer(), $event->getMessage());
                    $chatFlagEvent->call();
                    return;
                }
            }
        }
        if ($this->action == "censor") {
            $message = $event->getMessage();
            $event->setMessage(str_ireplace($this->config->get("filter-words"), "******", $event->getMessage()));
            if ($this->config->get("message-toggle") === true && $event->getMessage() != $message) {
                $event->getPlayer()->sendMessage(TextFormat::RED . $this->config->get("message"));
                $chatFlagEvent = new ChatFlaggedEvent($event->getPlayer(), $event->getMessage());
                $chatFlagEvent->call();
            }
        }

    }

}
