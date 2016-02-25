<?php

namespace Silk\Exceptions;

/**
 * Class NoDataFoundException
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Silk\Exceptions
 */
class NoDataFoundException extends \Exception
{
    protected $message = "Não foi encontrado nenhum dado para sua busca.";
}