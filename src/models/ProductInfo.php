<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-20
 * Time: 16:27
 */

namespace Wakup;


class ProductInfo
{
    private $name, $category, $active, $properties, $images;

    /**
     * @return string Product display name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name Product display name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string Product category identifier
     */
    public function getCategory() : string
    {
        return $this->category;
    }

    /**
     * @param string $category Product category identifier
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return bool Defines if the product is active and should be displayed on the ecommerce
     */
    public function getActive() : bool
    {
        return $this->active;
    }

    /**
     * @param bool $active Defines if the product is active and should be displayed on the ecommerce
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    /**
     * @return array Named array of product attribute values. The array keys represents the attribute identifier
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties Named array of product attribute values. The array keys represents the attribute identifier
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * @return ProductImage[] Product images
     */
    public function getImages() : array
    {
        return $this->images;
    }

    /**
     * @param ProductImage[] $images Product images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

}