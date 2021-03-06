# ScreenshotMaker
![screenshotmaker](https://user-images.githubusercontent.com/5629860/30274764-899423fa-9707-11e7-86d0-b98886184a6c.png)
## Description
ScreenshotMaker is a web app based on Laravel, provides possibility to make screenshot of any site
using Selenium and php-webdriver by <a href="https://github.com/facebook/php-webdriver">Facebook</a>

## Setup Application
* run ```composer install```
* create .env file from .env.example
* run ```php artisan key:generate```
* run ```php artisan storage:link```
* make sure you have permission to write into storage/app/public
* Application use Selenium Web Driver.
docker image: https://hub.docker.com/r/selenium/standalone-chrome/
* set Selenium Host in **.env** file with **SELENIUM_HOST=127.0.0.1:4444/wd/hub**

## Endpoints
* general functional: http://screen-maker.dev
* AJAX  
  * http://screen-maker.dev/getScreenshot

## Selenium Setup
To setup Selenium Server we need Docker.
to start container:<br>
```sudo docker run -d -p 4444:4444 -v /dev/shm:/dev/shm --restart=always selenium/standalone-chrome```
parameters: ```-d``` as daemon, ```—-restart=always``` restart on any failure, ```-p 4444:4444``` open port 4444
now we can set in **.env** file with **SELENIUM_HOST=SELENIUM_HOST=127.0.0.1:4444/wd/hub**
