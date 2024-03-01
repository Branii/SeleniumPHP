<?php 
date_default_timezone_set('Europe/Bratislava');
require_once("vendor/autoload.php"); 
// Import the WebDriver classes 
use Facebook\WebDriver\Chrome\ChromeDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;  
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy; 

 class SlovakiaTest extends Model{
    private static $driver;
    private static $counter = 0;
    public static function SlovakiaStart(String $currentTime, String $currentCount) {
  
            try {
                echo "### timeout retry ### " . $currentTime . PHP_EOL;
                self::getBrowser();
                sleep(5);
                $WebElement = self::$driver->findElement(WebDriverBy::className("btnBlue"));
                $WebElement->click();
                $webElementt = self::$driver->findElements(WebDriverBy::className("numbers"))[0];
                $inputString = $webElementt->getText();
                self::getParams($inputString, $currentTime, $currentCount);
                self::closeBrowser() ;
            } catch (\Throwable $th) {
                Monolog::logException($th);
            }
        
    }
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
            self::$driver->get("https://eklubkeno.etipos.sk/"); 
            self::$driver->manage()->timeouts()->implicitlyWait(5); // wait 10 seconds for the page to load
        } catch (\Throwable $th) {
            Monolog::logException($th);
        }

        /*
         $element = $driver->wait()->until(
         WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::name('username'))
         );
         */
    }
    public static function getElements(String $currenTime, String $currentCount) {
        try {
            $webElement = self::$driver->findElement(WebDriverBy::id("lastDrawNumbers")); 
            $inputString = $webElement->getText();
            self::getParams($inputString, $currenTime, $currentCount);
            self::closeBrowser() ;
        } catch (\Throwable $th) {
            Monolog::logException($th);
        }
    }
    public static function getDrawDate() {
        $lastDraw = self::$driver->findElement(WebDriverBy::id('_ctl0_ContentPlaceHolder_lblLastDrawTimeValue'));
        $rowContent = $lastDraw->getText();
        $lines = explode(" ", $rowContent);
        $dateCreated = $lines[0] . " " . $lines[1] . " " . $lines[2];
        $date = DateTime::createFromFormat('d. n. Y', $dateCreated);
        $formattedDate = $date->format('d-m-Y');
        return $formattedDate;
    }
    public static function getTimeFromElements() : mixed {
        try {
            $webElement = self::$driver->findElement(WebDriverBy::id("_ctl0_ContentPlaceHolder_lblLastDrawTimeValue")); 
            $siteTime = explode(" ", $webElement->getText())[3];
            return $siteTime . ":00";
        } catch (\Throwable $th) {
            Monolog::logException($th);
            return $th->getMessage();
        }
    }
    public static function closeBrowser() {
            if(self::$driver != null) {
                self::$driver->close();
                self::$driver->quit();
            }
    }
    public static function retryLogic (Int $counter, String $currentTime, String $currentCount) {
            $counter++;
            sleep(1);
            self::closeBrowser();
            self::SlovakiaStart($currentTime,$currentCount);
    }
    public static function getParams(String $inputString, String $currentTime, String $currentCount) {
        try {
           
            $inputString = explode("\n", $inputString);
            $param = array(
                ":draw_date" => implode("", explode("-", self::getDrawDate())) . $currentCount,
                ":draw_time" => $currentTime,
                ":draw_number" => implode(",", $inputString),
                ":draw_count" => $currentCount,
                ":date_created" => self::getDrawDate(),
                ":client" => 'box',
                ":get_time" => date("g:i:s"),
            );

           echo (new Model)->insertData("draw_10023",$param);
           self::closeBrowser();
        } catch (\Throwable $th) {
            Log::getLogger()->warning($th->getMessage());
        }
    }
    public static function getSlovakiaTime() {
        $slovakiaTimeZone = new DateTimeZone('Europe/Bratislava');
        $currentTime = new DateTime('now', $slovakiaTimeZone);
        return $currentTime->format('h:i:s');
    }
    
}


 