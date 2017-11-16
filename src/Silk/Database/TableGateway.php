<?php

namespace Silk\Database;

use PhpDocReader\Reader;
use Silk\Exceptions\NoTableFoundException;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;

/**
 * Class TableGateway
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Database
 */
class TableGateway extends AbstractTableGateway
{
    private $config;

    public function __construct($object, $adapter = null)
    {
        $this->config = Reader::getConfig($object);

        if (!array_key_exists('table', $this->config))
            throw new NoTableFoundException();

        $this->table = $this->config['table'];
        
        if(!empty($adapter))
            $this->adapter = $adapter;
        else
           $this->adapter = GlobalAdapterFeature::getStaticAdapter();

        $this->updateContext();
    }

    protected function updateContext()
    {
        if(isset($this->config['schema'])){
            $sql = 'USE ' . $this->config['schema'] . ';';
            $this->adapter->getDriver()->getConnection()->execute($sql);
        }
    }
}
