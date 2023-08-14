<?php

namespace EXP\ThirdParty\ACFGutenberg\Traits;

trait ClassCapturer
{    
    static function getClasses() {
        $classes = [];
        $classNames = self::classNames();
        $namespace = self::namespace;
        foreach ($classNames as $className ) 
        {
            $class = $namespace."\\".$className;
            $classes[] = new $class;
        }

        return $classes;
    }

    static function getBlockNames()
    {
        $blockNames = [];
        $classes = self::getClasses();
        foreach($classes as $class)
        {
            if(!$class->disable)
            {
                $blockNames[] = 'acf/'. str_replace('_' , '-' ,$class->getBlockName());
            }
        }

        return $blockNames;
    }
}
