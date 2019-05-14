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

    private $sku, $warehouseId, $name, $address, $latitude, $longitude, $distance,
        $shipmentTime, $postCode, $country, $region, $city, $phoneNumber;

    /**
     * Store constructor.
     * @param $sku string External store identifier / Sku
     * @param $warehouseId string External identifier for store warehouse
     * @param $name string Store display name
     * @param $address string Store physical address
     * @param $postCode string Location postcode
     * @param $city string City where the store is located
     * @param $region string Location region (province, state)
     * @param $country string Country name
     * @param $phoneNumber string Phone number
     * @param $latitude float Latitude component of store location coordinates
     * @param $longitude float Longitude component of store location coordinates
     * @param $distance float Distance in miles to search point, if any
     * @param $shipmentTime int Shipment time in days for products to arrive from central stock to current store
     */
    public function __construct(
        string $sku, ?string $warehouseId, ?string $name,
        string $address, string $postCode, string $city, string $region, string $country, string $phoneNumber,
        float $latitude, float $longitude, float $distance = 0, int $shipmentTime = 7
    )
    {
        $this->sku = $sku;
        $this->warehouseId = $warehouseId;
        $this->name = $name;
        $this->address = $address;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->distance = $distance;
        $this->shipmentTime = $shipmentTime;
        $this->postCode = $postCode;
        $this->city = $city;
        $this->region = $region;
        $this->country = $country;
        $this->phoneNumber = $phoneNumber;
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
     * @param string $sku External store identifier / Sku
     */
    public function setStoreId(string $sku): void
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
     * @param float $latitude Latitude component of store location coordinates
     */
    public function setLat(float $latitude): void
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

    /**
     * @param float $longitude Longitude component of store location coordinates
     */
    public function setLong(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float Distance in miles to search point, if any
     */
    public function getDistanceInMiles(): float
    {
        return $this->distance;
    }

    /**
     * @param float $distance Distance in miles to search point, if any
     */
    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

    /**
     * @return float Distance in kilometers to search point, if any
     */
    public function getDistanceInKms(): float
    {
        return $this->distance * 1.609344;
    }

    //TODO Remove dummy values from method responses
    /**
     * @return int Shipment time in days for products to arrive from central stock to current store
     */
    public function getShipmentTime(): int
    {
        return $this->shipmentTime ?? 7;
    }

    /**
     * @param int $shipmentTime Shipment time in days for products to arrive from central stock to current store
     */
    public function setShipmentTime(int $shipmentTime): void
    {
        $this->shipmentTime = $shipmentTime;
    }

    /**
     * @return string Location postcode
     */
    public function getPostCode(): string
    {
        return $this->postCode ?? '11801';
    }

    /**
     * @param string $postCode Location postcode
     */
    public function setPostCode(string $postCode): void
    {
        $this->postCode = $postCode;
    }

    /**
     * @return string Country name
     */
    public function getCountry(): string
    {
        return $this->country ?? 'Costa Rica';
    }

    /**
     * @param string $country Country name
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string Location region (province, state)
     */
    public function getRegion(): string
    {
        return $this->region ?? 'San José';
    }

    /**
     * @param string $region Location region (province, state)
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * @return string Phone number
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber ?? '02-0448-0419';
    }

    /**
     * @param string $phoneNumber Phone number
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string City where the store is located
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city City where the store is located
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }


}