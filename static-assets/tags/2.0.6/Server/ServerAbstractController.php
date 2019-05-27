<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Psr\Http\Message\ServerRequestInterface;
use tiFy\Kernel\Params\ParamsBag;
use tiFy\Plugins\StaticAssets\Contracts\ServerController;
use Zend\Diactoros\Response;

class ServerAbstractController extends ParamsBag implements ServerController
{
    use ServerResolver;

    /**
     * Instance du contrôleur de gestionnaire de ressources.
     * @var ServerManager
     */
    protected $app;

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct(ServerManager $app, $attrs = [])
    {
        $this->app = $app;

        parent::__construct($attrs);
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(ServerRequestInterface $request, $args)
    {
        $response = new Response();

        return $response;
    }
}