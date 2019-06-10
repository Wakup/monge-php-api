<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:42
 */

namespace Wakup;


class SystemActionCreditInfo extends SystemAction
{
    private $object;

    /**
     * @return UserCreditInfo|null User credit info
     */
    public function getCreditInfo() : ?UserCreditInfo
    {
        return $this->object;
    }

    /**
     * @param UserCreditInfo|null $object User credit info
     */
    public function setObjeto(?UserCreditInfo $object): void
    {
        $this->object = $object;
    }


}