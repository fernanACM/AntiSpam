# AntiSpamPro
**Antispam plugin with configurable delay, profanity filter (block swear words), automatic actions (kick, ban) and commands to change settings on the fly in console or in game.**

### Implementations
* Bug fixes and update to new API 4.0.
* Sounds in chat.
* Message customization.
---

### Config
```yaml
   #     _            _     _   ___                         ___             
   #    /_\    _ _   | |_  (_) / __|  _ __   __ _   _ __   | _ \  _ _   ___ 
   #   / _ \  | ' \  |  _| | | \__ \ | '_ \ / _` | | '  \  |  _/ | '_| / _ \
   #  /_/ \_\ |_||_|  \__| |_| |___/ | .__/ \__,_| |_|_|_| |_|   |_|   \___/
           By fernanACM and awzaw    |_|                                    
            
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
   Setkick-Message: "Spammers will be kicked"
   SetBan-Message: "Spammers will be banned"
   SetBan-IpMessage: "Spammers will be IP banned"
   SetBancid-Message: "Spammers will be CID banned"
   Ban-Message: "No Spam"

   # Warnings Messages
   warnings: 5
   Last-Warning: "CAREFUL... LAST WARNING"

   # Help Message
   help1: "/asp kick    set the punishment to kick"
   help2: "/asp ban     set the punishment to ban"
   help3: "/asp set 2   set minimum delay (1,2 or 3)"
   help4: "/asp         display the current minimum delay"

   # Rude filter
   Swear-Message: "No Swear Words Allowed"
   AntiSwearWords: true
   AntiRudeNames: true
```
### Commands
/asp - display the current AntiSpamPro settings

/asp kick - kick spammers

/asp ban - ban spammers

/asp banip - banip and ban spammers

/asp bancid - ban, banip and bancid spammers (if available)

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
