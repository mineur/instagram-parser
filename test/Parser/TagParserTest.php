<?php

namespace Mineur\InstagramParserTest\Parser;

use Mineur\InstagramParser\Exception\EmptyRequiredParamException;
use Mineur\InstagramParser\Http\GuzzleHttpClient;
use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\Model\QueryId;
use Mineur\InstagramParser\Parser\TagParser;
use Mineur\InstagramParserTest\TestCase\UnitTestCase;
use Mockery\MockInterface;
use Symfony\Component\VarDumper\VarDumper;

final class TagParserTest extends UnitTestCase
{
    /** @var MockInterface|GuzzleHttpClient */
    private $httpClient;
    
    /** @var TagParser */
    private $tagParser;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->httpClient = $this->mock(HttpClient::class);
        
        $queryId = new QueryId('124341332');
        $this->tagParser = new TagParser(
            $this->httpClient,
            $queryId
        );
    }
    
    /** @test */
    public function it_should_return_exception_if_parser_is_empty()
    {
        $this->expectException(EmptyRequiredParamException::class);
        
        $emptyOptions = [];
        $emptyTagsResponse = '';
        $this->shouldReturnTagsResponse($emptyOptions, $emptyTagsResponse);

        $this->tagParser->parse('', function() {});
    }
    
    public function shouldReturnTagsResponse(
        array $requestOptions,
        string $tagsResponse
    )
    {
        $this->httpClient
            ->shouldReceive('get')
            ->with('/graphql/query/', $requestOptions)
            ->once()
            ->andReturn($tagsResponse)
        ;
    }
}