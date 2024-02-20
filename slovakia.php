<?php 
date_default_timezone_set('Asia/Shanghai');
require_once("vendor/autoload.php"); 
require_once("includer.php");
use React\EventLoop\Loop;
use Facebook\WebDriver\WebDriverBy; 

$counter = 0;

$slovakiaTime  = (new Timeset())->getSlovakiaTime();
$SlovakiaRunner = React\EventLoop\Loop::get();
$SlovakiaRunner->addPeriodicTimer(1, function ()  use ($slovakiaTime){ // slovakia scan
    $currentTime = Slovakia::getSlovakiaTime();
    if(isset($slovakiaTime[$currentTime])){
        Slovakia::SlovakiaStart($currentTime, $slovakiaTime[$currentTime]);
    }
});

echo "### DATA FETCHER STARTED SLOVAKIA ###\n\n";

Loop::run();


