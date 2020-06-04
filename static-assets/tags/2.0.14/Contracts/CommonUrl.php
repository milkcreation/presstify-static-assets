<?php

namespace tiFy\Plugins\StaticAssets\Contracts;

use League\Glide\Signatures\SignatureInterface;

interface CommonUrl
{
    /**
     * Set the base URL.
     * @param string $baseUrl The base URL.
     */
    public function setBaseUrl($baseUrl);

    /**
     * Set the HTTP signature.
     * @param SignatureInterface|null $signature The HTTP signature used to sign URLs.
     */
    public function setSignature(SignatureInterface $signature = null);

    /**
     * Get the URL.
     * @param  string $path   The resource path.
     * @param  array  $params The manipulation parameters.
     * @return string The URL.
     */
    public function getUrl($path, array $params = []);
}