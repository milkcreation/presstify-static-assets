<?php

namespace tiFy\Plugins\StaticAssets\Common;

use Illuminate\Support\Arr;
use tiFy\Kernel\Params\ParamsBag;
use tiFy\Plugins\StaticAssets\Contracts\CommonParamsBag as CommonParamBagContract;

class CommonParamsBag extends ParamsBag implements CommonParamBagContract
{
    /**
     * {@inheritdoc}
     */
    public function parse($attrs = [])
    {
        parent::parse($attrs);

        foreach(['css', 'img', 'js'] as $type) :
            if ($mapping = $this->get($type, [])) :
                foreach($mapping as $path => $attrs) :
                    $this->set(
                        "{$type}.{$path}",
                        array_merge(
                            $this->get('defaults', []),
                            Arr::wrap($attrs)
                        )
                    );
                endforeach;
            endif;
        endforeach;
    }
}