<?php 
require $_SERVER['DOCUMENT_ROOT']. 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Monolog {
    public static function logException(Throwable $th) : void {
        $log = new Logger('Checkers');
        $log->pushHandler(new StreamHandler('logs.log', Logger::WARNING));
        $log->warning($th->getMessage());
    }
}
// simple logger