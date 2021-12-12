# AntiSpamPro

[![](https://poggit.pmmp.io/shield.state/AntiSpam)](https://poggit.pmmp.io/p/AntiSpam)
<a href="https://poggit.pmmp.io/p/AntiSpam"><img src="https://poggit.pmmp.io/shield.state/AntiSpam"></a>

[![](https://poggit.pmmp.io/shield.api/AntiSpam)](https://poggit.pmmp.io/p/AntiSpam)
<a href="https://poggit.pmmp.io/p/AntiSpam"><img src="https://poggit.pmmp.io/shield.api/AntiSpam"></a>

**Antispam plugin with configurable delay, profanity filter (block swear words), automatic actions (kick, ban) and commands to change settings on the fly in console or in game.**

![Captura de pantalla 2021-12-10 002457](https://user-images.githubusercontent.com/83558341/145521945-b1255cff-5ef2-4dfc-b1fd-303d10ef314f.png)
<a href="https://discord.gg/YyE9XFckqb"><img src="https://img.shields.io/discord/837701868649709568?label=discord&color=7289DA&logo=discord" alt="Discord" /></a>

**This is the updated version of 'AntiSpamPro', I am not the original author, Awzaw is the creator of this plugin.**

### Implementations
* Bug fixes and update to new API 4.0.
* Sounds in chat.
* Message customization.
---

### Config
```yaml
   #     _            _     _   ___                                
   #    /_\    _ _   | |_  (_) / __|  _ __   __ _   _ __   
   #   / _ \  | ' \  |  _| | | \__ \ | '_ \ / _` | | '  \  
   #  /_/ \_\ |_||_|  \__| |_| |___/ | .__/ \__,_| |_|_|_|
   #       By fernanACM and awzaw    |_|                                    
            
   #The delay is the minimum time in seconds allowed between chats, including warnings.
   #message to be sent if the player is sending spam
   #action to take after warnings, "kick" or "ban"
   #Kick message is displayed when kicking
   #warnings is the number of violations before action is taken

   # Prefix
   Prefix: "§l§7[§cAntiSpamPro§7]§8»§r "

   # Chat Cooldown
   Cooldown: 2
   Set-Cooldown: "AntiSpamPro settings have been changed"
   Invalid-Cooldown: "Please use a valid delay (1, 2 or 3)"

   # Cooldown Messages
   Message1: "Please be polite, do not chat too fast"
   Message2: "For help and chat join DISCORD at §6https://discord.gg/YyE9XFckqb"

   # Chat sanctions
   Action: "kick" # kick or ban
   kick-Message: "§cDon't spam, next time it will be a more drastic penalty"
   SetKickMessage: "Spammers will be kicked"
   SetBanMessage: "Spammers will be banned"
   SetBanipMessage: "Spammers will be IP banned"
   SetBancidMessage: "Spammers will be CID banned"
   Ban-Message: "No Spam"

   # Warnings Messages
   warnings: 5
   Last-Warning: "CAREFUL... LAST WARNING"

   # Help Message
   help: "/asp help"
   help2: "/asp set 2 (set minimum delay (1,2 or 3)"

   # Rude filter
   Swear-Message: "No Swear Words Allowed"
   AntiSwearWords: true
   AntiRudeNames: true
```

### Commands
/asp - display the current AntiSpamPro settings

/asp set {1, 2 or 3} - change the allowed delay between chat to 1, 2 or 3 seconds.

### Permissions

- Executing the command: ```asp.command```
- General use: ```asp.bypass```

### Contact 

| Redes | Tag | Link |
|-------|-------------|------|
| YouTube | fernanACM | [YouTube](https://www.youtube.com/channel/UC-M5iTrCItYQBg5GMuX5ySw) | 
| Discord | fernanACM#5078 | [Discord](https://discord.gg/YyE9XFckqb) |
| GitHub | fernanACM | [GitHub](https://github.com/fernanACM)
| Poggit | fernanACM | [Poggit](https://poggit.pmmp.io/ci/fernanACM)
****

### Credits

* **Original author: [Awzaw](https://github.com/Awzaw)**
