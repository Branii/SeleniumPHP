<?php 
date_default_timezone_set('Europe/Bratislava');
require_once("vendor/autoload.php"); 
require_once("includer.php");
use React\EventLoop\Loop;
$Loop = React\EventLoop\Loop::get();

$slovakiaTime  = (new Timeset())->getSlovakiaTime();
$canadaTime    = (new Timeset())->getCanadaTime();
$Loop->addPeriodicTimer(1, function () use ($slovakiaTime,$canadaTime ){ // slovakia scan
    
    // echo  $currentTimeSlovakia = Slovakia::getSlovakiaTime();
    // if(isset($slovakiaTime[$currentTimeSlovakia])){
    //     echo "######## BRANII #######: " . PHP_EOL;
    //     SlovakiaTest::SlovakiaStart($currentTimeSlovakia, $slovakiaTime[$currentTimeSlovakia]);
    // }

   echo $currentTimeCanada = Canada::getCanadaTime(); 
    $timeFormat = sprintf("%02d:%02d:%02d", date('g'), date('i'), date('s')) . PHP_EOL;
    if(isset($canadaTime[$currentTimeCanada])){
       try {
        Canada::CanadaStart($timeFormat, $canadaTime[$currentTimeCanada]);
       } catch (\Throwable $th) {
         Monolog::logException($th);
         echo $th->getMessage();
       }
    }

});
echo "### Running ###\n\n";
Loop::run();


