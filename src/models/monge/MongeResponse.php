<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-12
 * Time: 11:55
 */

namespace Wakup;

class MongeResponse
{
    var $response, $status, $traceInformation, $currentException;

    /**
     * @return array
     */
    public function getResponse() : array
    {
        return $this->response;
    }

    /**
     * @param array $response
     */
    public function setResponse(array $response): void
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getTraceInformation()
    {
        return $this->traceInformation;
    }

    /**
     * @param mixed $traceInformation
     */
    public function setTraceInformation($traceInformation): void
    {
        $this->traceInformation = $traceInformation;
    }

    /**
     * @return mixed
     */
    public function getCurrentException()
    {
        return $this->currentException;
    }

    /**
     * @param mixed $currentException
     */
    public function setCurrentException($currentException): void
    {
        $this->currentException = $currentException;
    }


}