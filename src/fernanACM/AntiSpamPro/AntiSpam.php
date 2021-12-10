<?php

namespace fernanACM\AntiSpamPro;

use fernanACM\AntiSpamPro\PluginUtils;
use fernanACM\AntiSpamPro\FilterPro;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerLoginEvent;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;

use pocketmine\Server;
use pocketmine\utils\TextFormat;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

class AntiSpam extends PluginBase implements CommandExecutor, Listener {

    private $players = [];
    public $FilterPro;

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        if ($this->getConfig()->get("AntiSwearWords") || $this->getConfig()->get("AntiRudeNames")) {
            $this->saveResource("SwearWords.yml", false);
            $this->FilterPro = new FilterPro($this);
        }
    }

    public function onChat(PlayerChatEvent $e) {
        if ($e->isCancelled() || ($player = $e->getPlayer())->isClosed() || $player->hasPermission("asp.bypass")) return;
        if (isset($this->players[spl_object_hash($player)]) && (time() - $this->players[spl_object_hash($player)]["time"] <= intval($this->getConfig()->get("Cooldown")))) {
            $this->players[spl_object_hash($player)]["time"] = time();
            $this->players[spl_object_hash($player)]["warnings"] = $this->players[spl_object_hash($player)]["warnings"] + 1;

            if ($this->players[spl_object_hash($player)]["warnings"] === $this->getConfig()->get("warnings")) {
                $player->sendMessage(TEXTFORMAT::RED . $this->getConfig()->get("Last-Warning"));
                $e->cancel();
                return;
            }
            if ($this->players[spl_object_hash($player)]["warnings"] > $this->getConfig()->get("warnings")) {
                $e->cancel();

                switch (strtolower($this->getConfig()->get("Action"))) {
                    case "kick":
                        $player->kick($this->getConfig()->get("kick-Message"));
                        break;

                    case "ban":
                        Server::getInstance()->getNameBans()->addBan($player, $this->getConfig()->get("Ban-Message"));
                        $player->kick($this->getConfig()->get("Ban-Message"));
                        break;

                    case "banip":

                        $this->getServer()->getIPBans()->addBan($player->getNetworkSession()->getIp(), $this->getConfig()->get("Ban-Message"), null, $player->getName());
                        $this->getServer()->getNetwork()->blockAddress($player->getNetworkSession()->getIp(), -1);
                        Server::getInstance()->getNameBans()->addBan($player, $this->getConfig()->get("Ban-Message"));
                        $player->kick($this->getConfig()->get("Ban-Message"));
                        break;

                    default:
                        break;
                }

                return;
            }
            $player->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Message1"));
            $player->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Message2"));
            PluginUtils::PlaySound($player, "random.orb", 1, 1.5);
            $e->cancel();
        } else {
            $this->players[spl_object_hash($player)] = array("time" => time(), "warnings" => 0);
            if ($this->getConfig()->get("AntiSwearWords") && $this->FilterPro->hasProfanity($e->getMessage())) {
                $player->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Swear-Message"));
                $e->cancel();
            }
        }
    }

    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool{
        if (!isset($args[0])) {
            if ($sender instanceof Player) {
                $sender->sendMessage($this->getConfig()->get("Prefix") . "Banmode: " . $this->getConfig()->get("Action") . "  " . "Delay: " . $this->getConfig()->get("Cooldown") . " seconds");
            } else {
                $this->getLogger()->info("Banmode: " . $this->getConfig()->get("Action") . "  " . "Delay: " . $this->getConfig()->get("Cooldown") . " seconds");
            }
            return true;
        }

        switch (strtolower($args[0])) {

            case "help":

                if ($sender instanceof Player) {
                    $sender->sendMessage(TEXTFORMAT::YELLOW . $this->getConfig()->get("help1"));
                    $sender->sendMessage(TEXTFORMAT::YELLOW . $this->getConfig()->get("help2"));
                    $sender->sendMessage(TEXTFORMAT::YELLOW . $this->getConfig()->get("help3"));
                    $sender->sendMessage(TEXTFORMAT::YELLOW . $this->getConfig()->get("help4"));
                } else {
                    $this->getLogger()->info($this->getConfig()->get("help1"));
                    $this->getLogger()->info($this->getConfig()->get("help2"));
                    $this->getLogger()->info($this->getConfig()->get("help3"));
                    $this->getLogger()->info($this->getConfig()->get("help4"));
                }

                return true;

            case "banip":
            case "ban":
            case "kick":
                $this->getConfig()->set("Action", strtolower($args[0]));
                $this->getConfig()->save();

                if ($sender instanceof Player) {
                    $sender->sendMessage(TEXTFORMAT::GREEN . $this->getConfig()->get("Set" . strtolower($args[0]) . "kick-Message"));
                } else {
                    $this->getLogger()->info($this->getConfig()->get("Set" . strtolower($args[0]) . "Message"));
                }

                return true;


            case "set":
                if (isset($args[1]) && is_numeric($args[1]) && $args[1] <= 3 && $args[1] > 0) {
                    $this->getConfig()->set("Cooldown", $args[1]);
                    $this->getConfig()->save();

                    if ($sender instanceof Player) {
                        $sender->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Set-Cooldown"));
                    } else {
                        $this->getLogger()->info($this->getConfig()->get("Set-Cooldown"));
                    }
                } else {

                    if ($sender instanceof Player) {
                        $sender->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Invalid-Cooldown"));
                    } else {
                        $this->getLogger()->info($this->getConfig()->get("Invalid-Cooldown"));
                    }
                }

                return true;

            default:
                break;
        }
        return false;
    }

    /**
     * @param PlayerCommandPreprocessEvent $event
     *
     * @priority LOWEST
     */

    public function onPlayerCommand(PlayerCommandPreprocessEvent $event) {
        if ($event->isCancelled() || $event->getPlayer()->isClosed()) return;
        if (($sender = $event->getPlayer())->hasPermission("asp.bypass")) return;
        $message = $event->getMessage();
        if ($message[0] != "/") {
            return;
        }
        if (isset($this->players[spl_object_hash($sender)]) && (time() - $this->players[spl_object_hash($sender)]["time"] <= intval($this->getConfig()->get("Cooldown")))) {
            $this->players[spl_object_hash($sender)]["time"] = time();
            $this->players[spl_object_hash($sender)]["warnings"] = $this->players[spl_object_hash($sender)]["warnings"] + 1;

            if ($this->players[spl_object_hash($sender)]["warnings"] === $this->getConfig()->get("warnings")) {
                $sender->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Last-warning"));
                $event->cancel();
                return;
            }
            if ($this->players[spl_object_hash($sender)]["warnings"] > $this->getConfig()->get("warnings")) {
                $event->cancel();

                switch (strtolower($this->getConfig()->get("Action"))) {
                    case "kick":
                        $sender->kick($this->getConfig()->get("Kick-Message"));
                        break;

                    case "ban":
                        Server::getInstance()->getNameBans()->addBan($sender, $this->getConfig()->get("Ban-Message"));
                        $sender->kick($this->getConfig()->get("Ban-Message"));
                        break;

                    case "banip":

                        $this->getServer()->getIPBans()->addBan($sender->getNetworkSession()->getIp(), $this->getConfig()->get("Ban-Message"), null, $sender->getName());
                        $this->getServer()->getNetwork()->blockAddress($sender->getNetworkSession()->getIp(), -1);
                        Server::getInstance()->getNameBans()->addBan($sender, $this->getConfig()->get("Ban-Message"));
                        $sender->kick($this->getConfig()->get("Ban-Message"));
                        break;

                    default:
                        break;
                }
                return;
            }
            $sender->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Message1"));
            $sender->sendMessage($this->getConfig()->get("Prefix") . $this->getConfig()->get("Message2"));
            PluginUtils::PlaySound($sender, "random.orb", 1, 1.5);
            $event->cancel();
        } else {
            $this->players[spl_object_hash($sender)] = array("time" => time(), "warnings" => 0);
        }
    }

    public function onQuit(PlayerQuitEvent $e)
    {
        if (isset($this->players[spl_object_hash($e->getPlayer())])) {
            unset($this->players[spl_object_hash($e->getPlayer())]);
        }
    }

    public function onLogin(PlayerLoginEvent $e)
    {
        if ($e->isCancelled() || $e->getPlayer()->isClosed()) return;
        if ($this->getConfig()->get("AntiRudeNames") && $this->FilterPro->hasProfanity($e->getPlayer()->getName())) {
            $e->getPlayer()->kick("No Rude Names Allowed");
            PluginUtils::PlaySound($player, "random.burp", 1, 1.5);
            $e->cancel();
        }
    }

    public function getFilterPro()
    {
        return $this->FilterPro;
    }
}
