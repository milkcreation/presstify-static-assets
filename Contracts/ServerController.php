<?php

namespace tiFy\Plugins\StaticAssets\Contracts;

use Psr\Http\Message\ServerRequestInterface;
use tiFy\Contracts\Kernel\ParamsBag;

interface ServerController extends ParamsBag, ServerResolver
{
    /**
     * Traitement de l'affichage de la ressource.
     *
     * @param ServerRequestInterface $request Requête serveur valide PSR.
     * @param ResponseInterface $response Réponse serveur valide PSR.
     * @param array $args Liste des variables passées en arguments.
     *
     * @return string
     */
    public function __invoke(ServerRequestInterface $request, $args);
}