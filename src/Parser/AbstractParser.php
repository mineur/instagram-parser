<?php

/*
 * Mineur/instagram-parser package
 *
 * Feel free to contribute!
 *
 * @license MIT
 * @author alexhoma <alexcm.14@gmail.com>
 */

namespace Mineur\InstagramParser\Parser;

use Mineur\InstagramParser\Exception\EmptyRequiredParamException;
use Mineur\InstagramParser\Model\InstagramPost;

/**
 * Class AbstractParser
 *
 * @package Mineur\InstagramParser\Parser
 */
abstract class AbstractParser
{
    /**
     * @param string   $parsedItem
     * @param callable $callback
     * @return mixed
     */
    abstract public function parse(
        string $parsedItem,
        callable $callback
    );
    
    /**
     * Return an hydrated InstagramPost object
     *
     * @param array         $post
     * @param callable|null $callback
     * @return InstagramPost|mixed
     */
    protected function returnPostObject(
        array $post,
        callable $callback = null
    )
    {
        if ($callback !== null) {
            return call_user_func(
                $callback,
                InstagramPost::fromArray($post)
            );
        }
        
        return InstagramPost::fromArray($post);
    }
    
    /**
     * Ensure there is something to parse
     *
     * @param string $tag
     * @throws EmptyRequiredParamException
     */
    protected function ensureParserIsNotEmpty(string $tag)
    {
        if (empty($tag)) {
            throw new EmptyRequiredParamException(
                'Your parser query cannot be an empty string.'
            );
        }
    }
}