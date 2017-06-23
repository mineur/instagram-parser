<?php

namespace Mineur\InstagramParser\Model;


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
    
    public static function fromArray(array $dimensions)
    {
        return new self(
            (int) $dimensions['height'],
            (int) $dimensions['width']
        );
    }
    
    /** @return int */
    public function getWidth(): int
    {
        return $this->width;
    }
    
    /** @return int */
    public function getHeight(): int
    {
        return $this->height;
    }
}