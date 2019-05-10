<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-05-10
 * Time: 14:57
 */

namespace Wakup;


class CategoryAttribute
{
    private $identifier, $order;

    /**
     * @return string Attribute identifier
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier Attribute identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return int Order of the attribute inside the category
     */
    public function getOrder() : int
    {
        return $this->order;
    }

    /**
     * @param int $order Order of the attribute inside the category
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }



}