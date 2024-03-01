<?php 
date_default_timezone_set('Europe/Bratislava');
require_once("vendor/autoload.php"); 
require_once("includer.php");
use React\EventLoop\Loop;
use Facebook\WebDriver\WebDriverBy; 

$counter = 0;

$slovakiaTime  = (new Timeset())->getSlovakiaTime();
$SlovakiaRunner = React\EventLoop\Loop::get();
$SlovakiaRunner->addPeriodicTimer(1, function ()  use ($slovakiaTime){ // slovakia scan
    echo $currentTime = Slovakia::getSlovakiaTime();
    if(isset($slovakiaTime[$currentTime])){
        Slovakia::SlovakiaStart($currentTime, $slovakiaTime[$currentTime]);
    }
});

echo "### Running ###\n\n";

Loop::run();


