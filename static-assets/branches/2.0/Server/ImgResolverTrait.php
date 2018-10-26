<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use League\Route\Route;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\SapiEmitter;

trait ImgResolverTrait
{
    /**
     * Instance du contrôleur de l'application.
     * @var ImgManager
     */
     protected $img;

    /**
     * Récupération d'attribut de configuration.
     * {@internal Retourne la liste complète si $key vaut null}
     *
     * @param null|string $key Clé d'indexe de l'attribut. Syntaxe à point permise. Tous si null.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return mixed
     */
    public function config($key = null, $default = null)
    {
        /** @var Fluent $config */
        $config = $this->img->container('img.config');

        if (is_null($key)) :
            return $config->toArray();
        else :
            return $config->get($key, $default);
        endif;
    }

    /**
     * Instance du contrôleur d'emission de la réponse HTTP.
     *
     * @return object|SapiEmitter
     */
    public function emitter()
    {
        return $this->img->container('img.emitter');
    }

    /**
     * Instance du contrôleur de requête HTTP.
     *
     * @return object|Request
     */
    public function request()
    {
        return $this->img->container('img.request');
    }

    /**
     * Instance du contrôleur de réponse HTTP.
     *
     * @return object|ResponseInterface
     */
    public function response()
    {
        return $this->img->container('img.response');
    }

    /**
     * Déclaration d'une route.
     *
     * @param array|string    $method
     * @param string          $path
     * @param string|callable $handler
     *
     * @return Route
     */
    public function route($method, $path, $handler)
    {
        $method = $method ? : 'GET';
        $path = $this->request()->getBaseUrl() . $path;

        return $this->router()->map($method, $path, $handler);
    }

    /**
     * Instance du contrôleur de routage.
     *
     * @return object|RouteCollection
     */
    public function router()
    {
        return $this->img->container('img.router');
    }

    /**
     * Instance du contrôleur de requête serveur HTTP.
     *
     * @return object|ServerRequestInterface
     */
    public function serverRequest()
    {
        return $this->img->container('img.request.server');
    }
}