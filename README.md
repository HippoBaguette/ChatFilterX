# ChatFilterX
Chat filter plugin for PocketMine-MP

**Permissions**
Permission | Description
------------ | -------------
chatfilter.bypass | Bypass the filter


**ChatFlaggedEvent**  
This plugin provides a new event that you can use. This event is called whenever a message is flagged. 

Example usage:
```php
use HippoBaguette\ChatFilter\ChatFlaggedEvent;

public function onChatFlag(ChatFlaggedEvent $event) {
    $event->getPlayer()->setBanned();
}
```


## Getting started
Get a precompiled binary from the [releases](https://github.com/HippoBaguette/ChatFilter/releases/)  

## Configuring the plugin
**Actions**  
An action is what happens when a message gets flagged. 
Action | Description
------------ | -------------
send | Send the message? (with the flagged words) (HippoBaguette is bad -> HippoBaguette is bad)
filter | Send the message without the flagged words (HippoBaguette is bad -> is bad)
censor | Send the message with the flagged words but censored  (HippoBaguette is bad -> ************ is bad)
block | Don't send the message.

**Message**  
You can send a message to the player, by setting message-toggle to true.
```yml
message-toggle: true
```
Then set `message` to the message you want to send.   
**Note:** the message will be in read. Support for different colors will come in a later update
```yml
message: You can't say that word!
```

## Contributing
Feel free to make an issue or a pull request
