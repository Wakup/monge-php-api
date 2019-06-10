<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-06-07
 * Time: 11:10
 */

namespace Wakup;


class SystemAction
{

    private $action;

    /**
     * @return string|null System action
     */
    public function getAction() : ?string
    {
        return $this->action;
    }

    /**
     * @param string|null $action System action
     */
    public function setAction(?string $action): void
    {
        $this->action = $action;
    }



}