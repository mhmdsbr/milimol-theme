<?php

namespace EXP\ThirdParty\ACFGutenberg\Parts;

use EXP\ThirdParty\ACFGutenberg\Traits\ClassCapturer;

class Part
{
    use ClassCapturer;

    const namespace = __NAMESPACE__;

    static function classNames()
    {
        // add your part class name here
        return [
//            'PartHeader',
//            'PartFooter',
        ];
    }
}
