<?php 
date_default_timezone_set('Asia/Shanghai');
require_once("vendor/autoload.php"); 
// Import the WebDriver classes 
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;  
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy; 

 class Tron extends Model{
    private static $driver;
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
            self::$driver->get("https://cryptolottery.info/en/tron"); 
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
            self::getParams($inputString, $currenTime, $currentCount);
            self::closeBrowser() ;
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
            echo "Element Error: => " . $th->getMessage();
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
            self::closeBrowser();
            self::getBrowser();
    }

    public static function getParams(String $inputString, String $currentTime, String $currentCount) {
        try {
            
            date_default_timezone_set('Asia/Shanghai');
            $splitString = preg_split("/\s+/", $inputString);
            $drawPeriod = ltrim($splitString[1], "#");
            $drawNumber = implode(",", array_slice($splitString, 2, 5));
            $dateCreated = $splitString[7];
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
           echo (new Model)->insertData("draw_10026",$param);

        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
        }
    }

    public static function NextDayChecker (String $currentTime, String $currentCount){

        try {
            self::closeBrowser();
            self::getBrowser();
            $dateTime = new DateTime(date("Y-m-d"));
            $dayPart = $dateTime->format('d');
            self::$driver->findElement(WebDriverBy::className("calendar-btn_date"))->click(); 
            $webElements = self::$driver->findElements(WebDriverBy::className("calendar-day"));
            foreach ($webElements as $webElement) {
                $liText = $webElement->getText();
                if ($liText == $dayPart) {
                    $webElement->click();
                    break; // Exit the loop when the desired element is found
                }
            } 
            self::$driver->findElement(WebDriverBy::className("confirm"))->click();
            sleep(6);
            $webElements = self::$driver->findElements(WebDriverBy::className("result-list")); 
            $webElement = $webElements[1];
            $inputString = $webElement->getText();
            self::getParams($inputString,$currentTime,$currentCount);

            // if ($currentTime == "00:06:00") {
            //     getElementInfo(elementList.get(2), "23:58:00", "0719", "off");
            //     getElementInfo(elementList.get(1), "00:00:00", "0720", "on");
            // }
            
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
            echo "Element Error: => " . $th->getMessage();
        }
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

 