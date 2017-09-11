<?php

namespace App\Helpers;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

class ScreenshotMaker
{
    protected $chromeSettings;
    protected $seleniumServer;
    protected $driver;
    protected static $sites;
    
    public function __construct()
    {
        $this->seleniumServer = env('SELENIUM_HOST');
        $this->chromeSettings = '--window-size=' . env('CHROME_WINDOW_SIZE');
        
        $options = new ChromeOptions();
        $options->addArguments([$this->chromeSettings]);
        $caps = DesiredCapabilities::chrome();
        $caps->setCapability(ChromeOptions::CAPABILITY, $options);
        
        $this->driver = RemoteWebDriver::create($this->seleniumServer, $caps);
    }
    
    /**
     * @param $data array ['siteUrl', 'filePath']
     */
    public function CreateSiteScreenshot($data)
    {
        $siteUrl = $data['siteUrl'];
        $filePath = $data['filePath'];
        
        $this->driver->get($siteUrl);
        
        $this->driver->wait(5);//w8 for 5 seconds to load all site content
        $this->driver->takeScreenshot($filePath);
    }
    
    public function __destruct()
    {
        $this->driver->close();
    }
}