<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Laminas\HttpHandlerRunner\Exception\EmitterException;
use League\Container\Container;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\MethodNotAllowedException;
use tiFy\Plugins\StaticAssets\Common\CommonServiceProvider;
use tiFy\Plugins\StaticAssets\Contracts\ServerManager as ServerManagerContract;

class ServerManager extends Container implements ServerManagerContract
{
    use ServerResolver;

    /**
     * Instance du contrôleur du gestionnaire de ressources.
     * @var ServerManager
     */
    protected $app;

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->app = $this;

        $this->addServiceProvider(new CommonServiceProvider());
        $this->addServiceProvider(new ServerServiceProvider());

        foreach (['css', 'img', 'js'] as $type) :
            foreach ($this->params($type, []) as $path => $attrs) :
                $this->route($type, 'GET', $path, $this->resolve("server.controller.{$type}", [$this, $attrs]));
            endforeach;
        endforeach;

        try {
            $response = $this->router()->dispatch($this->httpRequest());
        } catch (NotFoundException $e) {
            echo $e->getMessage();
            die(500);
        } catch (MethodNotAllowedException $e) {
            echo $e->getMessage();
            die(500);
        }

        if (isset($response)) :
            try {
                $emitter = $this->httpEmitter();
                $emitter->emit($response);
            } catch(EmitterException $e) {
                echo $e->getMessage();
                die(500);
            }
        endif;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($alias, $args = [])
    {
        return $this->get("assets.{$alias}", $args);
    }
}