<?php

/**
 * Exemple de configuration.
 */

return [
    // Paramètres de configuration par défaut.
    'defaults' => [
        /**
         * Clé de salage de sécurisation de récupération des ressources (recommandé).
         * @var string
         */
        'secure'       => '',

        /**
         * Url de la Cdn. Site courant par défaut.
         * @var string
         */
        'url'          => '',

        /**
         * Chemin relatif de base de récupération des récupération des ressources.
         * @var string
         */
        'base_url'     => '/{{rewrite_base}}/cdn',

        /**
         * Activation du mode de deboguage.
         * @var string
         */
        'debug'        => false
    ],
    // Paramètres de configuration des ressources de type image.
    'img' => [
        // Ex. de configuration pour le chemin ../images/..
        'images' => [
            /**
             * Chemin absolu du serveur de stockage des ressources (requis).
             * @var string
             */
            'source'       => getenv('RESOURCES_DIR') . '/customizer',

            /**
             * Chemin absolu vers le répertoire de mise en cache des ressources.
             * { @internal
             *  - false : Utilise la mémoire pour retourner la ressource.
             *  - Recommandé : Renseigner un répertoire publique du site.
             * }
             * @var boolean|string
             */
            'cache'        => false,

            /**
             * Chemin relatif vers l'image de remplacement.
             * @var string
             */
            'placeholder'       => '',

            /**
             * Chemin relatif vers de récupération des ressources.
             * @var string
             */
            'fallback_path' => ''
        ]
    ]
];