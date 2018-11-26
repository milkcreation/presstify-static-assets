<?php

namespace tiFy\Plugins\StaticAssets\Server;

use Illuminate\Http\Request;
use League\Route\Route;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use tiFy\Plugins\StaticAssets\Contracts\ServerParamsBag;
use tiFy\Plugins\StaticAssets\Contracts\CommonSignature;
use Zend\Diactoros\Response\SapiEmitter;

trait ServerResolver
{
    /**
     * Instance du contrôleur de l'application.
     * @var ServerManager
     */
     protected $app;

    /**
     * Instance du contrôleur d'émission de la réponse serveur HTTP.
     *
     * @return object|SapiEmitter
     */
    public function httpEmitter()
    {
        return $this->app->resolve('server.http.emitter');
    }

    /**
     * Instance du contrôleur de requête serveur HTTP.
     *
     * @return object|ServerRequestInterface
     */
    public function httpRequest()
    {
        return $this->app->resolve('server.http.request');
    }

    /**
     * Récupération de paramètre de configuration.
     * {@internal Retourne l'instance du controleur si $key vaut null}
     *
     * @param null|string $key Clé d'indexe de l'attribut. Syntaxe à point permise. Tous si null.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return mixed|ServerParamsBag
     */
    public function params($key = null, $default = null)
    {
        /** @var ServerParamsBag $params */
        $params = $this->app->resolve('common.params');

        if (is_null($key)) :
            return $params;
        else :
            return $params->get($key, $default);
        endif;
    }

    /**
     * Instance du contrôleur de requête HTTP.
     *
     * @return object|Request
     */
    public function request()
    {
        return $this->app->resolve('server.request');
    }

    /**
     * Déclaration d'une route.
     *
     * @param string $type Type de ressource concernée. css|img|js.
     * @param array|string $method Méthode de récupération de la requête. get|post.
     * @param string $path Chemin vers la resource.
     * @param string|callable $handler Function de traitement de la réponse.
     *
     * @return Route
     */
    public function route($type, $method, $path, $handler)
    {
        $method = $method ? : 'GET';

        if ($base_url = $this->params()->get("{$type}.{$path}.base_url")) :
            $path = '/' . rtrim(ltrim($base_url, '/'), '/') . '/' . $path;
        endif;
        $path .= '/{path:.*}';

        return $this->router()->map($method, $path, $handler);
    }

    /**
     * Instance du contrôleur de routage.
     *
     * @return object|RouteCollection
     */
    public function router()
    {
        return $this->app->resolve('server.router');
    }

    /**
     * Instance du contrôleur de routage.
     *
     * @return object|CommonSignature
     */
    public function signature($signkey)
    {
        return $this->app->resolve('common.signature', [$signkey]);
    }
}