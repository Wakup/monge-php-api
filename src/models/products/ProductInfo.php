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
    private $name, $description, $short_description, $category, $active, $properties;

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
    public function getCategory() : ?string
    {
        return $this->category;
    }

    /**
     * @param string $category Product category identifier
     */
    public function setCategory(?string $category): void
    {
        $this->category = $category;
    }

    /**
     * @return bool Defines if the product is active and should be displayed on the ecommerce
     */
    public function isActive() : bool
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
        // Extract static properties
        if ($properties != null) {
            $this->short_description = $properties['short_description']; unset($properties['short_description']);
            $this->description = $properties['description']; unset($properties['description']);
        }
        // Remove static values from properties array
        $this->properties = $properties;
    }

    // Static properties

    /**
     * @return string Product detailed description
     */
    public function getDescription() : ?string
    {
        return $this->description;
    }

    /**
     * @return string Product short description
     */
    public function getShortDescription() : ?string
    {
        return $this->short_description;
    }

    /**
     * @return array List of SKUs of products that should be included in the cart along with the main product
     */
    public function getRequiredProducts() : array
    {
        # TODO Extract required products from static properties
        return [];
    }

    /**
     * @return bool Defines if the product should be visible as individual product to the user while navigating on the
     * ecommerce or if it will always depend on a main product
     */
    public function isIndividualProduct() : bool
    {
        # TODO Extract required products from static properties
        return true;
    }


}