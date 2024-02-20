<?php 
date_default_timezone_set('Asia/Shanghai');
require_once("vendor/autoload.php"); 
require_once("includer.php");
use React\EventLoop\Loop;
use Facebook\WebDriver\WebDriverBy; 

$counter = 0;

$etherTime  = (new Timeset())->getEtherTime();
$EtherRunner = React\EventLoop\Loop::get();
$EtherRunner->addPeriodicTimer(1, function ()  use ($etherTime,$counter){ // ehter scan
    $currentTime = date("h:i:s");
    if(isset($etherTime[$currentTime])){
        try {
            echo "Requesting Ether data => " . $currentTime . PHP_EOL;
            Ether::getBrowser();
            sleep(15);
            $drawTime = Ether::getTimeFromElements();

            echo "[currentTime: {$currentTime}] <=> [siteTime: {$drawTime}]" . PHP_EOL;

            while (true) {

                if ($currentTime == $drawTime) {

                    Ether::getElements($currentTime, $etherTime[$currentTime]);
                    Ether::closeBrowser();
                    $counter = 0;
                    break;
                    
                }else {

                    if ($counter>= 10) { // 10 attempt for retry
                        echo ("Timed out!!!");
                        $counter = 0;
                        Ether::closeBrowser();
                        break;
                    } else {
                        $counter++;
                        echo "[currentTime: {$currentTime}] <=> [siteTime: {$drawTime}] -> Retrying..." . PHP_EOL;
                        Ether::retryLogic($counter);
                    }

                }

                sleep(1);

            }

        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
        }
    }
});

echo "### DATA FETCHER STARTED ETHERSCAN  ###\n\n";


Loop::run();