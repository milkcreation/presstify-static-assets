<?php

namespace tiFy\Plugins\StaticAssets\Server;

use League\Container\ContainerInterface;
use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use tiFy\Kernel\Params\ParamsBag;
use Zend\Diactoros\Response;

class ServerImgController extends ServerAbstractController
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ServerRequestInterface $request, $args)
    {
        $response = new Response();

        $path = $args['path'] ?? null;

        $server = ServerFactory::create([
            'source' => $this->get('source') ? : dirname(__DIR__) . '/Resources/source',
            'cache'  => $this->get('cache') ? : dirname(__DIR__) . '/Resources/cache'
        ]);

        if ($secure = $this->get('secure')) :
            try {
                ($this->signature($secure))
                    ->validateRequest(
                        $path,
                        $request->getQueryParams()
                    );
                $server->outputImage($path, $request->getQueryParams());
            } catch (SignatureException $e) {
                $response->getBody()->write($e->getMessage());
            }
        else :
            try {
                $server->outputImage($path, $request->getQueryParams());
            } catch (FileNotFoundException $e) {
                $this->get('debug', false)
                    ? $response->getBody()->write($e->getMessage())
                    : $server->outputImage($this->get('holder'), $request->getQueryParams());
            }
        endif;

        return $response;
    }
}