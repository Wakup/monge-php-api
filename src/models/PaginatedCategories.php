<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 18:42
 */

namespace Wakup;


class PaginatedCategories extends PaginatedResults
{
    private $categories;

    /**
     * @return Category[] List of obtained categories
     */
    public function getCategories() : array
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories(array $categories): void
    {
        $this->categories = $categories;
    }

}