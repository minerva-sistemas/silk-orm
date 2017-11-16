<?php

namespace Silk\Database;

use PhpDocReader\Reader;
use Silk\Exceptions\NoTableFoundException;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature\FeatureSet;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Silk\Database\AdapterPool;
use Zend\Db\TableGateway\Feature\SequenceFeature;

/**
 * Class TableGateway
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Database
 */
class TableGateway extends AbstractTableGateway
{
    private $config;

    public function __construct($object)
    {
        $this->config = Reader::getConfig($object);

        if (!array_key_exists('table', $this->config))
            throw new NoTableFoundException();

        $this->table = $this->config['table'];
       
        if(!isset($this->config['adapter']))
            $this->config['adapter'] = 'Default';
        
        $adapterPool = new AdapterPool();
        $this->adapter = $adapterPool->get($this->config['adapter']);

        $this->updateContext();

        $platform = $this->adapter->getPlatform()->getName();
        if(isset($this->config['schema']) && $platform == 'PostgreSQL'){
            $pk = $this->config['primary_key'];
            $sq = $this->config['table'] . '_' . $pk . '_seq';

            $this->featureSet = new FeatureSet();
            $this->featureSet->addFeature(new SequenceFeature($pk, $sq));
            $this->initialize();
        }
    }

    protected function updateContext()
    {
        $platform = $this->adapter->getPlatform()->getName();

        if(isset($this->config['schema']) && $platform == 'MySQL'){
            $sql = 'USE ' . $this->config['schema'] . ';';
            $this->adapter->getDriver()->getConnection()->execute($sql);

            $sql = 'SET FOREIGN_KEY_CHECKS = FALSE;';
            $this->adapter->getDriver()->getConnection()->execute($sql);
        }

        if(isset($this->config['schema']) && $platform == 'PostgreSQL'){
            $sql = 'SET SCHEMA \'' . $this->config['schema'] . '\';';
            $this->adapter->getDriver()->getConnection()->execute($sql);
        }
    }
}
