<?php

namespace popkechupki;

///////////////////////////////////////
//Development start date: 2016/07/26 //
//Last up date: 2016/07/26           //
///////////////////////////////////////
//////////////////////////////////////////////////////////////
//このプラグインはpopke LISENCEを理解および同意した上で使用する事。//
/////////////////////////////////////////////////////////////

/*use文*/
//default
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;
//command
use pocketmine\command\{Command, CommandSender};

class Timer extends PluginBase{

	public function onEnable(){
        $this->getLogger()->info(TextFormat::GREEN."Timerを読み込みました".TextFormat::GOLD." By popkechupki");
        $this->getLogger()->info(TextFormat::RED."このプラグインはpopke LICENSEに同意した上で使用してください。");
    }

    function onCommand(CommandSender $sender, Command $command, $label, array $args){
    	switch (strtolower($command->getName())){
    		case 'timer':
    			if(!$sender instanceof Player){
    				$this->getLogger()->warning("Please try in the game.");
    			}else{	
                    switch ($args[0]) {
                        case 'start':
                            if (!isset($args[1])) {
                                $sender->sendMessage("/timer start <seconds>");
                            }else{
                                $player = $sender->getPlayer();
                                $task = new timerplugin($this, $player);
                                $time = $args[1] * 20;
                                $this->getServer()->getScheduler()->scheduleDelayedTask($task, $time);
                                $sender->sendMessage("Timer is set ".$args[1]." seconds. It was started.");
                            }
                            break;

                        default:
                            $sender->sendMessage("/timer start <seconds>");
                            break;
                    }
        		}
    			break;
    	}
    }
}

class timerplugin extends PluginTask{

    const StopMessage = "Timer was stopped.";

    public function __construct(PluginBase $owner, Player $player) {
      parent::__construct($owner);
      $this->player = $player;//Playerデータを引き継ぎます
   }

   public function onRun($currentTick){
      $this->player->sendMessage(self::StopMessage);
   }
}