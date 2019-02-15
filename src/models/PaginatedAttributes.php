<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:42
 */

namespace Wakup;


class PaginatedAttributes extends PaginatedResults
{
    private $attributes;

    /**
     * @return Attribute[] List of obtained attributes
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

}