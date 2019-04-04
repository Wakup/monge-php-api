<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-04-04
 * Time: 12:59
 */

class AzureUser
{
    /**
     * @var $objectId string
     */
    private $objectId;

    /**
     * @return string
     */
    public function getObjectId(): string
    {
        return $this->objectId;
    }

    /**
     * @param string $objectId
     */
    public function setObjectId(string $objectId): void
    {
        $this->objectId = $objectId;
    }

}