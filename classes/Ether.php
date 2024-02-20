<?php 
date_default_timezone_set('Asia/Shanghai');
require_once("vendor/autoload.php"); 
// Import the WebDriver classes 
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;  
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy; 

 class Ether extends Model{
    private static $driver;
    private static $counter = 0;
    public static function getBrowser() {
        try {
            // Create an instance of ChromeOptions:
            $chromeOptions = new ChromeOptions();
            // Configure $chromeOptions
            $chromeOptions->addArguments(["--headless"]);
            // Set up the desired capabilities 
            $capabilities = DesiredCapabilities::chrome();
            $capabilities->setCapability("acceptInsecureCerts", true);
            $capabilities->setCapability(ChromeOptions::CAPABILITY, $chromeOptions);
            // Start a new web driver session
            self::$driver = ChromeDriver::start($capabilities);
            self::$driver->get("https://cryptolottery.info/en/ether"); 
            self::$driver->manage()->timeouts()->implicitlyWait(10); // wait 10 seconds for the page to load
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
            echo "Driver Error: => " . $th->getMessage();
        }

        /*
         $element = $driver->wait()->until(
         WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('username'))
         );
         */
    }

    public static function getElements(String $currenTime, String $currentCount) {
        try {
            $webElements = self::$driver->findElements(WebDriverBy::className("result-list")); 
            $webElement = $webElements[1];
            $inputString = $webElement->getText();
            self::getFirstTwo($currenTime,$webElements);
            self::getParams($inputString, $currenTime, $currentCount, "off");
            self::closeBrowser() ;
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
            echo "Element Error Ether: => " . $th->getMessage();
        }
    }

    public static function getTimeFromElements() : mixed {
        try {
            $webElements = self::$driver->findElements(WebDriverBy::className("result-list")); 
            $webElement = $webElements[1];
            $siteTime = explode(" ", $webElement->getText())[1];
            return $siteTime;
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
            return $th->getMessage();
        }
    }

    public static function closeBrowser() {
            self::$driver->close();
            self::$driver->quit();
    }

    public static function retryLogic (Int $counter) {
            $counter++;
            echo "Retry attempt: " . $counter . PHP_EOL;
            sleep(1);
            self::$driver->quit();
            self::closeBrowser();
            self::getBrowser();
    }

    public static function getParams(String $inputString, String $currentTime, String $currentCount, String $flag) {
        try {
            
            date_default_timezone_set('Asia/Shanghai');
            $splitString = preg_split("/\s+/", $inputString);
            $drawPeriod = ltrim($splitString[1], "#");
            $drawNumber = implode(",", array_slice($splitString, 2, 5));
            $dateCreated = $flag == "on" ? self::subtractOneDay() : $splitString[7];
            $drawTime = $splitString[8];
            $param = array(
                ":draw_date" => $drawPeriod,
                ":draw_time" => $drawTime,
                ":draw_number" => $drawNumber,
                ":draw_count" => $currentCount,
                ":date_created" => $dateCreated,
                ":client" => 'box',
                ":get_time" => date("H:i:s"),
            );
           echo (new Model)->insertData("draw_10027",$param);

        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
        }
    }

    public static function getFirstTwo ($currentTime,$webElements){
        if ($currentTime == "00:05:00") {
           self::getParams($webElements[2]->getText(), "00:55:00", "0287","off"); 
           self::getParams($webElements[1]->getText(), "00:00:00", "0288","on");
        } 
    }

    public static function subtractOneDay (){
        $today = new DateTime();
        $yesterday = $today->sub(new DateInterval('P1D'));
        echo 'Yesterday: ' . $yesterday->format('Y-m-d');
    }

    public static function getDateTime(String $dateTime) : array{
        $pattern = '/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})/';
        if(preg_match($pattern, $dateTime, $matches)){
            $dateTime = $matches[1];
            $dateTimeObj = new DateTime($dateTime);
            return ['date'=>$dateTimeObj->format('Y-m-d'),'time'=> $dateTimeObj->format('H:i:s')];
        }
        return ['message'=>'No match found'];
    }
}

 