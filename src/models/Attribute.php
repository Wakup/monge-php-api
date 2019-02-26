<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-15
 * Time: 17:56
 */

namespace Wakup;


class Attribute
{
    private $identifier, $name, $type, $values, $visible, $filterable, $translatable, $mandatory, $order;

    /**
     * @return string Attribute string identifier
     */
    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    /**
     * @return string Display name
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string Attribute type. Available values are string, text, boolean, numeric, enum
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @return string[] Array of available values for enum attribute types
     */
    public function getValues() : ?array
    {
        return $this->values;
    }

    /**
     * @return bool Defines if the attribute will be visible for user
     */
    public function getVisible() : bool
    {
        return $this->visible;
    }

    /**
     * @return bool Defines if the attribute can be used to filter products on the grid
     */
    public function getFilterable() : bool
    {
        return $this->filterable;
    }

    /**
     * @return bool Defines if the attribute allows customized or translatable values for different countries
     */
    public function getTranslatable() : bool
    {
        return $this->translatable;
    }

    /**
     * @return bool Defines if the attribute is mandatory when creating
     */
    public function getMandatory() : bool
    {
        return $this->mandatory;
    }

    /**
     * @return int Display order for attribute
     */
    public function getOrder() : int
    {
        return $this->order;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string[] $values
     */
    public function setValues(?array $values): void
    {
        $this->values = $values;
    }

    /**
     * @param bool $visible
     */
    public function setVisible(bool $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @param bool $filterable
     */
    public function setFilterable(bool $filterable): void
    {
        $this->filterable = $filterable;
    }

    /**
     * @param bool $translatable
     */
    public function setTranslatable(bool $translatable): void
    {
        $this->translatable = $translatable;
    }

    /**
     * @param bool $mandatory
     */
    public function setMandatory(bool $mandatory): void
    {
        $this->mandatory = $mandatory;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

}