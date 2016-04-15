<?php

namespace ezoterik\rollbarJs;

use Yii;
use yii\base\Application;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;

class Bootstrap extends Object
{
    /** @var string|null */
    public $accessToken = null;

    /** @var array Client options. See https://rollbar.com/docs/notifier/rollbar.js/configuration */
    public $clientOptions = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->attachEvent();

        parent::init();
    }

    /**
     * @return bool
     */
    protected function attachEvent()
    {
        if (!$this->isPossibleRegisterJs()) {
            return false;
        }

        $accessToken = $this->accessToken;

        if (
            empty($accessToken) &&
            isset(Yii::$app->params['rollbar']['postClientItemAccessToken']) &&
            !empty(Yii::$app->params['rollbar']['postClientItemAccessToken'])
        ) {
            $accessToken = Yii::$app->params['rollbar']['postClientItemAccessToken'];
        }

        if (empty($accessToken)) {
            return false;
        }

        Yii::$app->on(Application::EVENT_BEFORE_REQUEST, function () use ($accessToken) {
            $config = ArrayHelper::merge(
                [
                    'accessToken' => $accessToken,
                    'captureUncaught' => true,
                    'payload' => [
                        'environment' => 'production',
                    ],
                ],
                $this->clientOptions
            );

            Yii::$app->getView()->registerJs('
            var _rollbarConfig = ' . Json::encode($config) . ';
            // Rollbar Snippet
            !function(r){function o(e){if(t[e])return t[e].exports;var n=t[e]={exports:{},id:e,loaded:!1};return r[e].call(n.exports,n,n.exports,o),n.loaded=!0,n.exports}var t={};return o.m=r,o.c=t,o.p="",o(0)}([function(r,o,t){"use strict";var e=t(1).Rollbar,n=t(2);_rollbarConfig.rollbarJsUrl=_rollbarConfig.rollbarJsUrl||"https://d37gvrvc0wt4s1.cloudfront.net/js/v1.8/rollbar.min.js";var a=e.init(window,_rollbarConfig),i=n(a,_rollbarConfig);a.loadFull(window,document,!_rollbarConfig.async,_rollbarConfig,i)},function(r,o){"use strict";function t(r){return function(){try{return r.apply(this,arguments)}catch(o){try{console.error("[Rollbar]: Internal error",o)}catch(t){}}}}function e(r,o,t){window._rollbarWrappedError&&(t[4]||(t[4]=window._rollbarWrappedError),t[5]||(t[5]=window._rollbarWrappedError._rollbarContext),window._rollbarWrappedError=null),r.uncaughtError.apply(r,t),o&&o.apply(window,t)}function n(r){var o=function(){var o=Array.prototype.slice.call(arguments,0);e(r,r._rollbarOldOnError,o)};return o.belongsToShim=!0,o}function a(r){this.shimId=++p,this.notifier=null,this.parentShim=r,this._rollbarOldOnError=null}function i(r){var o=a;return t(function(){if(this.notifier)return this.notifier[r].apply(this.notifier,arguments);var t=this,e="scope"===r;e&&(t=new o(this));var n=Array.prototype.slice.call(arguments,0),a={shim:t,method:r,args:n,ts:new Date};return window._rollbarShimQueue.push(a),e?t:void 0})}function l(r,o){if(o.hasOwnProperty&&o.hasOwnProperty("addEventListener")){var t=o.addEventListener;o.addEventListener=function(o,e,n){t.call(this,o,r.wrap(e),n)};var e=o.removeEventListener;o.removeEventListener=function(r,o,t){e.call(this,r,o&&o._wrapped?o._wrapped:o,t)}}}var p=0;a.init=function(r,o){var e=o.globalAlias||"Rollbar";if("object"==typeof r[e])return r[e];r._rollbarShimQueue=[],r._rollbarWrappedError=null,o=o||{};var i=new a;return t(function(){if(i.configure(o),o.captureUncaught){i._rollbarOldOnError=r.onerror,r.onerror=n(i);var t,a,p="EventTarget,Window,Node,ApplicationCache,AudioTrackList,ChannelMergerNode,CryptoOperation,EventSource,FileReader,HTMLUnknownElement,IDBDatabase,IDBRequest,IDBTransaction,KeyOperation,MediaController,MessagePort,ModalWindow,Notification,SVGElementInstance,Screen,TextTrack,TextTrackCue,TextTrackList,WebSocket,WebSocketWorker,Worker,XMLHttpRequest,XMLHttpRequestEventTarget,XMLHttpRequestUpload".split(",");for(t=0;t<p.length;++t)a=p[t],r[a]&&r[a].prototype&&l(i,r[a].prototype)}return r[e]=i,i})()},a.prototype.loadFull=function(r,o,e,n,a){var i=function(){var o;if(void 0===r._rollbarPayloadQueue){var t,e,n,i;for(o=new Error("rollbar.js did not load");t=r._rollbarShimQueue.shift();)for(n=t.args,i=0;i<n.length;++i)if(e=n[i],"function"==typeof e){e(o);break}}"function"==typeof a&&a(o)},l=!1,p=o.createElement("script"),c=o.getElementsByTagName("script")[0],s=c.parentNode;p.crossOrigin="",p.src=n.rollbarJsUrl,p.async=!e,p.onload=p.onreadystatechange=t(function(){if(!(l||this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState)){p.onload=p.onreadystatechange=null;try{s.removeChild(p)}catch(r){}l=!0,i()}}),s.insertBefore(p,c)},a.prototype.wrap=function(r,o){try{var t;if(t="function"==typeof o?o:function(){return o||{}},"function"!=typeof r)return r;if(r._isWrap)return r;if(!r._wrapped){r._wrapped=function(){try{return r.apply(this,arguments)}catch(o){throw o._rollbarContext=t()||{},o._rollbarContext._wrappedSource=r.toString(),window._rollbarWrappedError=o,o}},r._wrapped._isWrap=!0;for(var e in r)r.hasOwnProperty(e)&&(r._wrapped[e]=r[e])}return r._wrapped}catch(n){return r}};for(var c="log,debug,info,warn,warning,error,critical,global,configure,scope,uncaughtError".split(","),s=0;s<c.length;++s)a.prototype[c[s]]=i(c[s]);r.exports={Rollbar:a,_rollbarWindowOnError:e}},function(r,o){"use strict";r.exports=function(r,o){return function(t){if(!t&&!window._rollbarInitialized){var e=window.RollbarNotifier,n=o||{},a=n.globalAlias||"Rollbar",i=window.Rollbar.init(n,r);i._processShimQueue(window._rollbarShimQueue||[]),window[a]=i,window._rollbarInitialized=!0,e.processPayloads()}}}}]);
            // End Rollbar Snippet
            ', View::POS_HEAD, 'rollbarJs');
        });

        return true;
    }

    /**
     * @return bool
     */
    protected function isPossibleRegisterJs()
    {
        return (
            Yii::$app->getRequest()->getIsGet() &&
            !Yii::$app->getRequest()->getIsAjax()
        );
    }
}
