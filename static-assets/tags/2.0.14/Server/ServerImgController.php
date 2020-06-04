<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Exception;
use Laminas\Diactoros\Response;
use League\Glide\ServerFactory;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use Psr\Http\Message\ServerRequestInterface;

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
            'cache'  => $this->get('cache') ? : new Filesystem(new MemoryAdapter())
        ]);

        if ($secure = $this->get('secure')) {
            try {
                ($this->signature($secure))->validateRequest($path, $request->getQueryParams());
                $server->outputImage($path, $request->getQueryParams());
            } catch (Exception $e) {
                $response->getBody()->write($e->getMessage());
            }
        } else {
            try {
                $server->outputImage($path, $request->getQueryParams());
            } catch (Exception $e) {
                $this->get('debug', false)
                    ? $response->getBody()->write($e->getMessage())
                    : $server->outputImage($this->get('placeholder'), $request->getQueryParams());
            }
        }

        return $response;
    }
}