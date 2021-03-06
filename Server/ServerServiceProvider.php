<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Illuminate\Http\Request;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use League\Route\Router;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

class ServerServiceProvider extends AbstractServiceProvider implements BootableServiceProviderInterface
{
    /**
     * @var array
     */
    protected $provides = [
        'assets.server.controller.css',
        'assets.server.controller.img',
        'assets.server.controller.js',
        'assets.server.http.emitter',
        'assets.server.http.request',
        'assets.server.request',
        'assets.server.router'
    ];

    /**
     * @inheritdoc
     */
    public function boot()
    {

    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerServerControllers();

        $this->registerServerHttp();

        $this->registerServerRequest();

        $this->registerServerRouter();
    }

    /**
     * Déclaration des contrôleurs de traitement des ressources.
     *
     * @return void
     */
    public function registerServerControllers()
    {
        $this->getContainer()->add('assets.server.controller.css', function ($app, $attrs = []) {
            return new ServerCssController($app, $attrs);
        });

        $this->getContainer()->add('assets.server.controller.img', function ($app, $attrs = []) {
            return new ServerImgController($app, $attrs);
        });

        $this->getContainer()->add('assets.server.controller.js', function ($app, $attrs = []) {
            return new ServerJsController($app, $attrs);
        });
    }

    /**
     * Déclaration des contrôleurs de traitement HTTP.
     *
     * @return void
     */
    public function registerServerHttp()
    {
        $this->getContainer()->share('assets.server.http.emitter', new SapiEmitter());

        $this->getContainer()->share('assets.server.http.request', function () {
            $psr17Factory = new Psr17Factory();
            $psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

            return $psrHttpFactory->createRequest($this->getContainer()->get('assets.server.request'));
        });
    }

    /**
     * Déclaration du contrôleur de traitement des requêtes.
     *
     * @return void
     */
    public function registerServerRequest()
    {
        $this->getContainer()->share('assets.server.request', function () {
            return Request::createFromGlobals();
        });
    }

    /**
     * Déclaration du contrôleur de traitement du routage.
     *
     * @return void
     */
    public function registerServerRouter()
    {
        $this->getContainer()->share('assets.server.router', new Router());
    }
}