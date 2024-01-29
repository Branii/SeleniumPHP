<?php 

// function myAutoloader($class) {
//     foreach ($dirs as $dir) {
//         $filename = $dir . DIRECTORY_SEPARATOR . $class . '.php';
//         if (file_exists($filename)) {
//             include $filename;
//             return;
//         }
//     }
// }
// // Register the autoloader
// spl_autoload_register('myAutoloader');

spl_autoload_register(function ($class){
    $dirs = ['classes', 'database', 'model', 'logs'];
    foreach ($dirs as $dir) {
        $filename = $dir . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($filename)) {
            include $filename;
            return;
        }
    }
});