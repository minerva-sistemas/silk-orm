<?php

namespace Silk\Test;

use Silk\Model\AbstractMappableModel;

/**
 * Class Company
 * @author  Lucas A. de Araújo <lucas@painapp.com.br>
 * @package Silk\Test
 * @configure {"table":"cad_company"}
 * @configure {"primary_key":"idcompany"}
 */
class  Company extends AbstractMappableModel
{
    /**
     * @var int
     */
    protected $idcompany;

    /**
     * @var string
     */
    private $name;

    /**
     * @configure {"ignore":true}
     */
    private $ignored;

    /**
     * Retorna o nome da compania
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define o nome da compania
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}