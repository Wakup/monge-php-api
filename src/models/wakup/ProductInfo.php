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
    private $name, $category, $active, $properties;
    // Static properties
    /**
     * @var $staticProperties array
     */
    private $staticProperties;
    const PROP_SHORT_DESCRIPTION = 'short_description';
    const PROP_DESCRIPTION = 'description';
    const PROP_WARRANTY = 'has-warranty-plans';
    const PROP_RELATED_PRODUCTS = 'related-products';
    const PROP_REQUIRED_PRODUCTS = 'required-products';
    const PROP_VISIBLE_INDIVIDUALLY = 'visible-individually';
    const STATIC_PROPERTIES = [
        self::PROP_SHORT_DESCRIPTION,
        self::PROP_DESCRIPTION,
        self::PROP_WARRANTY,
        self::PROP_RELATED_PRODUCTS,
        self::PROP_REQUIRED_PRODUCTS,
        self::PROP_VISIBLE_INDIVIDUALLY
    ];

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
        $this->staticProperties = array();
        if ($properties != null) {
            foreach (self::STATIC_PROPERTIES as $staticKey) {
                $value = null;
                if (array_key_exists($staticKey, $properties)) {
                    $value = $properties[$staticKey];
                    unset($properties[$staticKey]);
                }
                $this->staticProperties[$staticKey] = $value;
            }
        }
        $this->properties = $properties;
    }

    // Static properties

    /**
     * @return string Product detailed description
     */
    public function getDescription() : ?string
    {
        return $this->staticProperties[self::PROP_DESCRIPTION];
    }

    /**
     * @return string[] Obtains the list of elements that make up the short description
     */
    public function getShortDescriptionItems() : array
    {
        return array_filter(explode('*', $this->staticProperties[self::PROP_SHORT_DESCRIPTION] ?? ''));
    }

    /**
     * @return string Product short description as result of joinint shortDescriptionItems
     */
    public function getShortDescription() : ?string
    {
        $value = "";
        foreach ($this->getShortDescriptionItems() as $hit) {
            $value .= "- {$hit}<br/>";
        }
        return $value;
    }

    /**
     * @return array List of SKUs of products that should be included in the cart along with the main product
     */
    public function getRequiredProducts() : array
    {
        return $this->staticProperties[self::PROP_REQUIRED_PRODUCTS] ?? [];
    }

    /**
     * @return array List of SKUs of products related to current
     */
    public function getRelatedProducts() : array
    {
        return $this->staticProperties[self::PROP_RELATED_PRODUCTS] ?? [];
    }

    /**
     * @return bool Defines if the product should be visible as individual product to the user while navigating on the
     * ecommerce or if it will always depend on a main product
     */
    public function isVisibleIndividually() : bool
    {
        return $this->staticProperties[self::PROP_VISIBLE_INDIVIDUALLY] ?? false;
    }

    /**
     * @return bool Returns true if the product is available for extended warranty plans
     */
    public function hasWarrantyPlans() : bool
    {
        return $this->staticProperties[self::PROP_WARRANTY] ?? false;
    }


}