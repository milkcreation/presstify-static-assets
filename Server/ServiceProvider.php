<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Zend\Diactoros\Response\SapiEmitter;

class ServiceProvider extends AbstractServiceProvider
{
    /**
     * Instance du conteneur d'injection de dépendances.
     * @var $this
     */
    protected $app;

    /**
     * @var array
     */
    protected $provides = [
        'img',
        'img.config',
        'img.emitter',
        'img.response',
        'img.request',
        'img.router',
        'img.request.server'
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share('img', function () {
            return new ImgManager($this->getContainer());
        });

        $this->getContainer()->share(
            'img.config',
            function() {
                $attrs = require_once(ABSPATH. 'wp-content/themes/' . get_option('template') . '/config/static-assets.php');
                return new Fluent($attrs);
            }
        );
        $this->getContainer()->share('img.emitter', new SapiEmitter());

        $this->getContainer()->share('img.response', function () {
            return (new DiactorosFactory())->createResponse(new Response());
        });

        $this->getContainer()->share('img.request', function () {
            return Request::createFromGlobals();
        });

        $this->getContainer()->share('img.router', new RouteCollection($this->getContainer()));

        $this->getContainer()->share('img.request.server', function () {
            return (new DiactorosFactory())->createRequest($this->getContainer()->get('img.request'));
        });


    }
}