<?php

namespace Silk\Configuration;

use PhpDocReader\Reader;
use Silk\Model\MappableModelInterface;

/**
 * Class PropertyConfiguration
 *
 * Objeto responsável por armazenar as configurações de um determinado objeto,
 * de modo a permitir uma leitura simplificada de como um determinado código deve
 * operar sobre uma propriedade de acordo com os parâmetros estabelecidos.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Configuration
 */
class PropertyConfiguration
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var bool
     */
    private $ignore;

    /**
     * @var bool
     */
    private $ignoreIfNull;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var string
     */
    private $type;

    /**
     * Constrói uma configuração
     * @param $property
     * @param $object
     */
    public function __construct(\ReflectionProperty $property, $object)
    {
        $property->setAccessible(true);
        $c = $property->class;
        $p = $property->getName();

        $config = Reader::getConfig($c, $p);

        $this->setName($property->getName());
        $this->setValue($property->getValue($object));

        if (array_key_exists('alias', $config))
            $this->setAlias($config['alias']);

        if (array_key_exists('ignore', $config))
            $this->setIgnore($config['ignore']);

        if (array_key_exists('ignoreIfNull', $config))
            $this->setIgnoreIfNull($config['ignoreIfNull']);

        if (array_key_exists('type', $config))
            $this->setType($config['type']);
    }

    /**
     * Retorna o nome da propriedade
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define o nome da propriedade
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if ($this->value instanceof MappableModelInterface) {
            return $this->value->getId();
        }

        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Retorna o parâmetro de ignorar a propriedade.
     * @return boolean
     */
    public function ignore()
    {
        return $this->ignore;
    }

    /**
     * Define o parâmetro de ignorar a propriedade
     * @param boolean $ignore
     */
    public function setIgnore($ignore)
    {
        $this->ignore = $ignore;
    }

    /**
     * Retorna o valor do parâmetro de ignorar a propriedade
     * @return boolean
     */
    public function ignoreIfNull()
    {
        return $this->ignoreIfNull;
    }

    /**
     * Verifica se o valor deve ser ignorado.
     * @return bool
     */
    public function shouldIgnoreIfNull() {
        if ($this->ignoreIfNull() && is_null($this->getValue()))
        {
            return true;
        } else
        {
            return false;
        }
    }

    /**
     * Define o parâmetro de ignorar a propriedade
     * @param boolean $ignoreIfNull
     */
    public function setIgnoreIfNull($ignoreIfNull)
    {
        $this->ignoreIfNull = $ignoreIfNull;
    }

    /**
     * Verifica se contém um alias na configuração
     * @return bool
     */
    public function hasAlias()
    {
        return (is_null($this->alias) === false);
    }

    /**
     * Retorna o alias da configuração
     * @return string
     */
    public function getAlias()
    {
        if (!empty($this->alias))
            return $this->alias;

        return $this->name;
    }

    /**
     * Define o alias da configuração
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}