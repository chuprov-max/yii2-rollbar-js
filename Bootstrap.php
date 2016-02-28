<?php

namespace ezoterik\rollbarJs;

use yii\base\BootstrapInterface;
use yii\base\Application;
use yii\web\View;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        if (!$app->getRequest()->getIsGet() || $app->getRequest()->getIsAjax()) {
            return;
        }

        // delay attaching event handler to the view component after it is fully configured
        $app->on(Application::EVENT_BEFORE_REQUEST, function () use ($app) {
            $app->getView()->on(View::EVENT_BEGIN_BODY, [$this, 'renderCode']);
        });
    }

    /**
     * Вывод кода
     *
     * @param Event $event
     */
    public function renderCode(Event $event)
    {
        /* @var $view View */
        $view = $event->sender;

        if (
            !isset(Yii::$app->params['rollbar']['postClientItemAccessToken']) ||
            empty(Yii::$app->params['rollbar']['postClientItemAccessToken'])
        ) {
            return;
        }

        echo $view->renderFile(__DIR__ . '/views/js.php', [
            'postClientItemAccessToken' => Yii::$app->params['rollbar']['postClientItemAccessToken'],
        ]);
    }
}
