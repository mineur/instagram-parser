<?php

namespace Mineur\InstagramParser\Parser;

use Mineur\InstagramParser\EmptyRequiredParamException;
use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\InstagramException;

/**
 * Class UserAbstractParser
 *
 * @package Mineur\InstagramParser\Parser
 */
class UserParser extends AbstractParser
{
    // TODO: Parse user info
    // TODO: Parse each user posts
    // TODO: Construct and return a response User object
    
    /** @var HttpClient */
    private $httpClient;
    
    /**
     * InstagramParser constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }
    
    public function parse(
        string $username,
        callable $callback = null
    )
    {
        $this->ensureUsernameIsNotEmpty($username);
        
        while(true) {
            $endpoint = sprintf('/%s/?__a=1',
                $username
            );
    
            return $this->makeRequest($endpoint);
        }
    }
    
    private function makeRequest(string $endpoint): array
    {
        $response = $this
            ->httpClient
            ->get($endpoint);
        
        return json_decode((string) $response, true);
    }
    
    private function ensureUsernameIsNotEmpty(string $username)
    {
        if (empty($username) || !isset($username)) {
            throw new EmptyRequiredParamException(
                'Username can not be empty.'
            );
        }
    }
}