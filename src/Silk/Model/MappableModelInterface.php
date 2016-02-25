<?php

namespace Silk\Model;

/**
 * Interface MappableModelInterface
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Model
 */
interface MappableModelInterface
{
    public function getId();
    public function setId($id);
}