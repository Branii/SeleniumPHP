<?php 
date_default_timezone_set('Asia/Shanghai');
require_once("vendor/autoload.php"); 
require_once("includer.php");
use React\EventLoop\Loop;
use Facebook\WebDriver\WebDriverBy; 

$counter = 0;

$tronTime  = (new Timeset())->getTronTime();

$loop = React\EventLoop\Loop::get();
$timer = $loop->addPeriodicTimer(1, function ()  use ($tronTime,$counter){
    $currentTime = date("H:i:s");
    
    if(isset($tronTime[$currentTime])){
        try {
            echo "Requesting data => " . $currentTime . PHP_EOL;
            Tron::getBrowser();
            sleep(10);
            $drawTime = Tron::getTimeFromElements();

            echo "[currentTime: {$currentTime}] <=> [siteTime: {$drawTime}]" . PHP_EOL;
           
                while (true) {
    
                    if ($drawTime === $currentTime) {
                        Tron::getElements($currentTime, $tronTime[$currentTime]);
                        Tron::closeBrowser();
                        $counter = 0;
                        break;
                    } else {
                        if ($counter >= 10) { // 10 attempt for retry
                            echo ("Timed out!!!");
                            $counter = 0;
                            Tron::closeBrowser();
                            break;
                        } else {
                            $counter++;
                            echo "[currentTime: {$currentTime}] <=> [siteTime: {$drawTime}] -> Retrying..." . PHP_EOL;
                            Tron::retryLogic($counter);
                        }
                    }
                    sleep(1);
                }
            
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
        }
    }
   // echo 'Tick: ' . $currentTime . PHP_EOL;
});
echo "### DATA FETCHER STARTED ###\n\n";
Loop::run();