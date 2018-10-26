<?php

namespace tiFy\Plugins\StaticAssets\Client;

use League\Glide\Signatures\Signature;
use League\Glide\Urls\UrlBuilder;
use Symfony\Component\Finder\Finder;
use tiFy\Kernel\Parameters\ParamsBagController;

class ClientController extends ParamsBagController
{
    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(config('static-assets'));
    }

    /**
     * Retrouve le chemin vers une ressource du dossier local.
     *
     * @param string $filename Nom du fichier à retrouver. Avec ou sans extension selon le param $regex.
     * @param array $paths Liste des chemins relatifs des repertoires du dossier local à inspecter, par ordre de priorité.
     * @param string $regex Recherche du nom. ex. fichiers images uniquement : '/^%s(.jpg|.jpeg|.png)?$/'.
     *
     * @return string
     */
    public function findPathname($filename, $paths = [], $regex = '%s')
    {
        if ($default = $this->get('default_path')) :
            $paths[] = $default;
        endif;

        $dirs = [];
        foreach ($paths as $path) :
            if (is_dir($this->localDir($path))) :
                $dirs[] = $this->localDir($path);
            endif;
        endforeach;

        if (!empty($dirs)) :
            $finder = new Finder();
            $finder
                ->in($dirs)
                ->depth('==0')
                ->files()
                ->name(sprintf($regex, $filename));

            foreach ($finder as $file) :
                return preg_replace('#^' .preg_quote($this->localDir(), '/'). '#', '', $file->getPathname());
            endforeach;
        endif;

        return '';
    }

    /**
     * Chemin absolu vers une ressource locale.
     * {@internal Retourne le chemin absolu vers la racine du répertoire de stockage des ressources locales.}
     *
     * @param string $path Chemin relatif vers la ressource.
     *
     * @return string
     */
    public function localDir($path = '')
    {
        return rtrim($this->get('source'), '/') . '/' . ltrim($path, '/');
    }

    /**
     * Normalisation du chemin vers un répertoire ou vers un fichier.
     *
     * @param string $path
     *
     * @return string
     */
    public function normalize($path)
    {
        return '/' . ltrim(rtrim($path, '/'), '/');
    }

    /**
     * Récupération de l'url vers une ressource du serveur.
     * {@internal Si $path est null, retourne l'url vers la racine du serveur}
     *
     * @param string $path Chemin relatif vers une ressource.
     * @param array $params Liste des arguments passés en paramètres à la requête.
     *
     * @return string
     */
    public function url($path = null, $params = [])
    {
        if (is_null($path)) :
            return rtrim((($url = $this->get('url')) ? $url : home_url('/')), '/') .
                (($base_path = $this->get('base_path')) ? '/' . ltrim(rtrim($base_path, '/'), '/') : '');
        elseif ($secure = $this->get('secure')) :
            return $this->url() . (new UrlBuilder('', new Signature($secure)))->getUrl($path, $params);
        else :
            return add_query_arg($params, $this->url() . $this->normalize($path)
            );
        endif;
    }
}