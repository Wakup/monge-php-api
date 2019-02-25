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
    private $aspectRatio, $backgroundColor, $width, $height, $url;

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
     * @return string Image source URL
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $url Image source URL
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

}