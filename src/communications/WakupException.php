<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-18
 * Time: 18:50
 */

namespace Wakup;


class WakupException extends \Exception
{

    var $baseException;

    /**
     * WakupException constructor.
     * @param $baseException
     */
    public function __construct($baseException)
    {
        parent::__construct($baseException.$this->getMessage());
        $this->baseException = $baseException;
    }

    /**
     * @return \Exception
     */
    public function getBaseException() : \Exception
    {
        return $this->baseException;
    }

}