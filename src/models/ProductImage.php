<?php
/**
 * Created by PhpStorm.
 * User: agutierrez
 * Date: 2019-02-20
 * Time: 15:54
 */

namespace Wakup;

/**
 * Class ProductImage
 * @package Wakup
 */
class ProductImage
{
    private $aspectRatio, $backgroundColor, $width, $height, $thumbnail, $small, $medium, $large;

    /**
     * @return float Image aspect ratio (width / height)
     */
    public function getAspectRatio() : float
    {
        return $this->aspectRatio;
    }

    /**
     * @param float $aspectRatio Image aspect ratio (width / height)
     */
    public function setAspectRatio(float $aspectRatio): void
    {
        $this->aspectRatio = $aspectRatio;
    }

    /**
     * @return string Hex code of image predominant color ("#FFFFFF", "#0D77BB", "#FDB813")
     */
    public function getBackgroundColor() : string
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $backgroundColor Hex code of image predominant color ("#FFFFFF", "#0D77BB", "#FDB813")
     */
    public function setBackgroundColor(string $backgroundColor): void
    {
        $this->backgroundColor = $backgroundColor;
    }

    /**
     * @return int Image original width
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * @param int $width Image original width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int Image original height
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * @param int $height Image original height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string URL for thumbnail image (max size 150x150)
     */
    public function getThumbnail() : string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail URL for thumbnail image (max size 150x150)
     */
    public function setThumbnail(string $thumbnail): void
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return string URL for small size image (max size 350350)
     */
    public function getSmall() : string
    {
        return $this->small;
    }

    /**
     * @param string $small URL for small size image (max size 350350)
     */
    public function setSmall(string $small): void
    {
        $this->small = $small;
    }

    /**
     * @return string URL for medium size image (max size 800x800)
     */
    public function getMedium() : string
    {
        return $this->medium;
    }

    /**
     * @param string $medium URL for medium size image (max size 800x800)
     */
    public function setMedium(string $medium): void
    {
        $this->medium = $medium;
    }

    /**
     * @return string URL for large size image (max size 1200x1200)
     */
    public function getLarge() : string
    {
        return $this->large;
    }

    /**
     * @param string $large URL for large size image (max size 1200x1200)
     */
    public function setLarge(string $large): void
    {
        $this->large = $large;
    }


}