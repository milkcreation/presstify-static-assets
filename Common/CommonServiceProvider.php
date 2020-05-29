<?php

namespace tiFy\Plugins\StaticAssets\Common;

use League\Container\ServiceProvider\AbstractServiceProvider;

class CommonServiceProvider extends AbstractServiceProvider
{
    /**
     * @var array
     */
    protected $provides = [
        'assets.common.params',
        'assets.common.signature',
        'assets.common.url',
    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->getContainer()->share('assets.common.params', function () {
            $attrs = include(ABSPATH . 'wp-content/themes/' . get_option('template') . '/config/static-assets.php');

            return (new CommonParamsBag())->set($attrs)->parse();
        });

        $this->getContainer()->add('assets.common.signature', function ($signkey) {
            return new CommonSignature($signkey);
        });

        $this->getContainer()->add('assets.common.url', function ($base_url = '', $signature = null) {
            return new CommonUrl($base_url, $signature);
        });
    }
}