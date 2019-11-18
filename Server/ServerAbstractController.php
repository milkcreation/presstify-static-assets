<?php declare(strict_types=1);

namespace tiFy\Plugins\StaticAssets\Server;

use Psr\Http\Message\ServerRequestInterface;
use tiFy\Plugins\StaticAssets\Contracts\ServerController;
use Zend\Diactoros\Response;
use tiFy\Support\ParamsBag;

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

        $this->set($attrs)->parse();
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