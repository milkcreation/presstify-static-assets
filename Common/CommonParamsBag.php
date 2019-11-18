<?php declare(strict_types=1);

namespace tiFy\Plugins\StaticAssets\Common;

use Illuminate\Support\Arr;
use tiFy\Plugins\StaticAssets\Contracts\CommonParamsBag as CommonParamBagContract;
use tiFy\Support\ParamsBag;

class CommonParamsBag extends ParamsBag implements CommonParamBagContract
{
    /**
     * @inheritDoc
     */
    public function parse(): ?CommonParamBagContract
    {
        parent::parse();

        foreach(['css', 'img', 'js'] as $type) {
            if ($mapping = $this->get($type, [])) {
                foreach ($mapping as $path => $attrs) {
                    $this->set(
                        "{$type}.{$path}",
                        array_merge(
                            $this->get('defaults', []),
                            Arr::wrap($attrs)
                        )
                    );
                }
            }
        }

        return $this;
    }
}