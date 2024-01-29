<?php 
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
class Log{

    public static function  getLogger() : Logger {
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('logs/logfile.log', Logger::WARNING));
        return $log;
    }

}