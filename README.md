Rollbar notifier for JavaScript
===============================
Integration Rollbar notifier for JavaScript

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist ezoterik/yii2-rollbar-js "*"
```

or add

```
"ezoterik/yii2-rollbar-js": "*"
```

to the require section of your `composer.json` file.


Usage
-----

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