<?php

namespace Silk\Exchange\Extractor;

use Silk\Configuration\PropertyConfiguration;

/**
 * Class Extractor
 * Responsável por executar a extração dos dados do objeto.
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Exchange\Extractor
 */
class Extractor
{
    /**
     * Extrai as informações existentes em uma classe
     * @param $object
     * @return array
     */
    public static function extract($object, $parent = true)
    {
        $array = [];

        $class = (new \ReflectionClass($object))->getProperties();

        if($parent == false)
            $class = (new \ReflectionClass($object))->getParentClass()->getProperties();

        foreach ($class as $property) {
            $config = new PropertyConfiguration($property, $object);

            if ($config->ignore() || $config->shouldIgnoreIfNull())
                continue;

            $name = $config->getAlias();
            $data = $config->getValue();

            $array[$name] = $data;
        }

        return $array;
    }
}