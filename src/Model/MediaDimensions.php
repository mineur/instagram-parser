<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\InstagramParser\Model;


/**
 * Class MediaDimensions
 *
 * @package Mineur\InstagramParser\Model
 */
class MediaDimensions
{
    /** @var int */
    private $height;
    
    /** @var int */
    private $width;
    
    /**
     * MediaDimensions constructor.
     *
     * @param int $height
     * @param int $width
     */
    private function __construct(
        int $height,
        int $width
    )
    {
        $this->height = $height;
        $this->width  = $width;
    }
    
    /**
     * Create Media Dimensions from array
     *
     * @param array $dimensions
     * @return MediaDimensions
     */
    public static function fromArray(array $dimensions)
    {
        return new self(
            (int) $dimensions['height'],
            (int) $dimensions['width']
        );
    }
    
    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'height' => (int) $this->height,
            'width'  => (int) $this->width
        ];
    }
    
    /** @return int */
    public function getWidth(): int
    {
        return (int) $this->width;
    }
    
    /** @return int */
    public function getHeight(): int
    {
        return (int) $this->height;
    }
}