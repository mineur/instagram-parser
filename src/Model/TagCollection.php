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
 * Class TagCollection
 *
 * @package Mineur\InstagramParser\Model
 */
class TagCollection
{
    /**
     * @var array
     */
    private $tags = [];
    
    /**
     * TagCollection constructor.
     *
     * @param array $tags
     */
    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }
    
    /**
     * @param string $text
     * @return TagCollection
     */
    public static function fromString(? string $text): self
    {
        if (null === $text) {
            return new self([]);
        }
        
        preg_match_all("/(#\w+)/u", $text, $tags);
    
        $cleanTags = [];
        foreach ($tags as $tag) {
            $cleanTags[] = str_replace('#', '', $tag);
        }
        
        return new self($cleanTags[0]);
    }
    
    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}