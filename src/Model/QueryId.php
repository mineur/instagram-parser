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

use Mineur\InstagramParser\Exception\EmptyRequiredParamException;

class QueryId
{
    private $id;
    
    /**
     * QueryId constructor.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->ensureQueryIdIsNotEmpty($id);
        
        $this->id = $id;
    }
    
    /**
     * @return string
     */
    function __toString()
    {
        return (string) $this->id;
    }
    
    /**
     * Ensure Instagram GraphQL query
     * has a non empty queryId
     *
     * @param string $id
     * @return string
     * @throws EmptyRequiredParamException
     */
    private function ensureQueryIdIsNotEmpty(string $id)
    {
        if (empty($id)) {
            throw new EmptyRequiredParamException(
                'You must include a valid queryId.'
            );
        }
    }
}