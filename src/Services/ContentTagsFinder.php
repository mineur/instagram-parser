<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\InstagramParser;

class ContentTagsFinder
{
    private $content;
    
    function __construct(string $content)
    {
        $this->content = $content;
    }
    
    /**
     * @return array
     */
    public function find(): array
    {
        preg_match_all("/(#\w+)/u", $this->content, $tags);
        $tags = $this->removeHashtagSymbol($tags[0]);
        
        return $tags;
    }
    
    /**
     * @param array $tags
     * @return array
     */
    private function removeHashtagSymbol(array $tags): array
    {
        $cleanTags = [];
        foreach ($tags as $tag) {
            $cleanTags[] = str_replace('#', '', $tag);
        }
        
        return $cleanTags;
    }
}