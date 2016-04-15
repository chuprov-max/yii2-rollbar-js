Rollbar notifier for JavaScript
===============================
This extension is the way to integrate [Rollbar notifier for JavaScript](https://rollbar.com/docs/notifier/rollbar.js) with your Yii2 application.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ezoterik/yii2-rollbar-js "~1.1.0"
```

or add

```
"ezoterik/yii2-rollbar-js": "~1.1.0"
```

to the require section of your `composer.json` file.


Usage
-----

0. Add the component configuration in your *web* config file:
 ```php
 'bootstrap' => ['rollbarJs'],
 'components' => [
     'rollbarJs' => [
         'class' => 'ezoterik\rollbarJs\Bootstrap',
         'accessToken' => 'POST_CLIENT_ITEM_ACCESS_TOKEN',
         
         // You can specify client options (see https://rollbar.com/docs/notifier/rollbar.js/configuration):
         // 'clientOptions' => [
         //     'logLevel' => 'error',
         //     'ignoredMessages' => ['Can\'t find Clippy.bmp. The end is nigh.'],
         // ],
     ],
 ],
 ```

or (deprecated method)

0. Add the param in your *params* config file:
 ```php
 'rollbar' => [
     'postClientItemAccessToken' => 'POST_CLIENT_ITEM_ACCESS_TOKEN',
 ],
 ```

0. Add the bootstrap class in your *web* config file:
 ```php
 'bootstrap' => ['ezoterik\rollbarJs\Bootstrap'],
 ```