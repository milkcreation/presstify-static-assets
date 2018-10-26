<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Dotenv\Dotenv;
use League\Container\ContainerInterface;
use League\Glide\Signatures\Signature;
use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Http\Exception\MethodNotAllowedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ImgManager
{
    use ImgResolverTrait;

    /**
     * Instance du contrôleur du gestionnaire des images.
     * @var $this
     */
    protected $img;

    /**
     * Instance du conteneur d'injection de dépendances.
     * @var ContainerInterface
     */
    protected $container;

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->img = $this;
        $this->container = $container;

        $path = '';
        if ($prefix = $this->request()->server('CONTEXT_PREFIX')) :
            $path = rtrim($prefix, '/');
        endif;
        if ($base_url = $this->config('base_url')) :
            $path .= '/' . rtrim(ltrim($base_url, '/'), '/');
        endif;
        $path .= '/{path:.*}';

        // Routage.
        $this->route(
            'GET',
            $path,
            function (ServerRequestInterface $request, ResponseInterface $response, $args) {
                $path = $args['path'] ?? null;

                $server = ServerFactory::create([
                    'source' => $this->config('source') ? : dirname(__DIR__) . '/Resources/source',
                    'cache'  => $this->config('cache') ? : dirname(__DIR__) . '/Resources/cache'
                ]);

                if ($secure = $this->config('secure')) :
                    try {
                        (new Signature($secure))
                            ->validateRequest(
                                $path,
                                $request->getQueryParams()
                            );
                        $server->outputImage($path, $request->getQueryParams());
                    } catch (SignatureException $e) {
                        $this->config('debug', false)
                            ? $response->getBody()->write($e->getMessage())
                            : $server->outputImage($this->config('holder'), $request->getQueryParams());

                    }
                else :
                    try {
                        $server->outputImage($path, $request->getQueryParams());
                    } catch (FileNotFoundException $e) {
                        $this->config('debug', false)
                            ? $response->getBody()->write($e->getMessage())
                            : $server->outputImage($this->config('holder'), $request->getQueryParams());
                    }
                endif;

                return $response;
            });

        try {
            $response = $this->router()->dispatch(
                $this->serverRequest(),
                $this->response()
            );
            $this->emitter()->emit($response);
        } catch (NotFoundException $e) {
            echo $e->getMessage();
            die(500);
        } catch (MethodNotAllowedException $e) {
            echo $e->getMessage();
            die(500);
        }
    }

    /**
     * Récupération d'une instance du conteneur d'injection ou d'un dépendance.
     *
     * @return ContainerInterface|object
     */
    public function container($alias = null)
    {
        if (is_null($alias)) :
            return $this->container;
        else :
            return $this->container->get($alias);
        endif;
    }
}