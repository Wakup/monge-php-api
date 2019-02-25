<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-18
 * Time: 19:00
 */

namespace Wakup;


class Category
{

    private $identifier, $name, $parentCategory, $attributes;

    /**
     * @return string Category identifier
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    /**
     * @param string Category identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @return string Category display name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string Category display name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string Parent category identifier
     */
    public function getParentCategory() : ?string
    {
        return $this->parentCategory;
    }

    /**
     * @param string $parentCategory
     */
    public function setParentCategory($parentCategory): void
    {
        $this->parentCategory = $parentCategory;
    }

    /**
     * @return string[] List of attributes for this category
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @param string[] List of attributes for this category
     */
    public function setAttributes(array $attributes): void
    {
        $this->attributes = $attributes;
    }

}