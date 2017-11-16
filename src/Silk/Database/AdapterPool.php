<?php

namespace Silk\Database;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * AdapterPool
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Database
 */
class AdapterPool
{
    /**
     * Pool of adapters
     *
     * @var array
     */
    protected static $pool = [];

    /**
     * @param $key
     * @param Adapter $adapter
     * @return $this
     */
    public function add($key, Adapter $adapter)
    {
        self::$pool[$key] = $adapter;
        return $this;
    }

    /**
     * @param $key
     * @return $this
     */
    public function remove($key)
    {
        unset(self::$pool[$key]);
        return $this;
    }

    /**
     * @param $key
     * @return Adapter
     */
    public function get($key)
    {
        return self::$pool[$key];
    }
}
