# Screenshotter

## Description
ScreenshotMaker provides possibility to make screenshot of any sites

## Usage

## Setup Application
* create .env file from .env.example
* run ```php artisan key:generate```
* Application use Selenium Web Driver.
docker image: https://hub.docker.com/r/selenium/standalone-chrome/
set Selenium Host in **.env** file with **SELENIUM_HOST=127.0.0.1:4444/wd/hub**
* set application url in **.env** **APP_URL=http://screenshotter.dev**
* check config for sites: **config/sites.php**
* run ```php artisan passport:keys```
* add to cronjob ```* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1```

## Endpoints
* general functional: http://screen-maker.dev
* AJAX
  * http://screen-maker.dev/getSites
  * http://screen-maker.dev/getScreenshot

## Selenium Setup
To setup Selenium Server we need Docker.
to start container:<br>
```sudo docker run -d -p 4444:4444 -v /dev/shm:/dev/shm --restart=always selenium/standalone-chrome```
parameters: ```-d``` as daemon, ```—-restart=always``` restart on any failure, ```-p 4444:4444``` open port 4444
now we can set in **.env** file with **SELENIUM_HOST=SELENIUM_HOST=127.0.0.1:4444/wd/hub**
