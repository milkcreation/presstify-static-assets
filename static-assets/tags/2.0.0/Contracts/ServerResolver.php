<?php

namespace tiFy\Plugins\StaticAssets\Contracts;

use Illuminate\Http\Request;
use League\Route\Route;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\SapiEmitter;

interface ServerResolver
{
    /**
     * Instance du contrôleur d'émission de la réponse serveur HTTP.
     *
     * @return object|SapiEmitter
     */
    public function httpEmitter();

    /**
     * Instance du contrôleur de requête serveur HTTP.
     *
     * @return object|ServerRequestInterface
     */
    public function httpRequest();

    /**
     * Instance du contrôleur de réponse serveur HTTP.
     *
     * @return object|ResponseInterface
     */
    public function httpResponse();

    /**
     * Récupération de paramètre de configuration.
     * {@internal Retourne l'instance du controleur si $key vaut null}
     *
     * @param null|string $key Clé d'indexe de l'attribut. Syntaxe à point permise. Tous si null.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return mixed
     */
    public function params($key = null, $default = null);

    /**
     * Instance du contrôleur de requête HTTP.
     *
     * @return object|Request
     */
    public function request();

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
    public function route($type, $method, $path, $handler);

    /**
     * Instance du contrôleur de routage.
     *
     * @return object|RouteCollection
     */
    public function router();
}