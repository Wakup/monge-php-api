<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-03-29
 * Time: 10:27
 */

namespace Wakup;


class Store
{

    private $id, $sku, $warehouseId, $name, $address, $latitude, $longitude;

    /**
     * Store constructor.
     * @param $sku string External store identifier / Sku
     * @param $warehouseId string External identifier for store warehouse
     * @param $name string Store display name
     * @param $address string Store physical address
     * @param $latitude float Latitude component of store location coordinates
     * @param $longitude float Longitude component of store location coordinates
     */
    public function __construct(string $sku, ?string $warehouseId, ?string $name, string $address, float $latitude, float $longitude)
    {
        $this->sku = $sku;
        $this->warehouseId = $warehouseId;
        $this->name = $name;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return string External store identifier / Sku
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @param string $sku External store identifier / Sku
     */
    public function setSku(string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string External identifier for store warehouse
     */
    public function getWarehouseId(): ?string
    {
        return $this->warehouseId;
    }

    /**
     * @param string $warehouseId External identifier for store warehouse
     */
    public function setWarehouseId(?string $warehouseId): void
    {
        $this->warehouseId = $warehouseId;
    }

    /**
     * @return string Store display name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name Store display name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string Store physical address
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address Store physical address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return float Latitude component of store location coordinates
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude Latitude component of store location coordinates
     */
    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return float Longitude component of store location coordinates
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude Longitude component of store location coordinates
     */
    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }


}