<?php

namespace Mineur\InstagramParserTest;

use Mineur\InstagramParser\Exception\EmptyRequiredParamException;
use Mineur\InstagramParser\Http\GuzzleHttpClient;
use Mineur\InstagramParser\Http\HttpClient;
use Mineur\InstagramParser\Model\InstagramPost;
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
        $this->tagParser = $this->mock(TagParser::class);
    }
    
    /** @test */
    public function it_should_return_exception_if_parser_is_empty()
    {
        $this->expectException(EmptyRequiredParamException::class);
        
        $emptyOptions = [];
        $emptyTagsResponse = '';
        $this->shouldReturnTagsResponse($emptyOptions, $emptyTagsResponse);
        
        $tagParser = new TagParser(
            $this->httpClient,
            new QueryId('12342341')
        );
        $tagParser->parse('', function($post) {
            return $post;
        });
    }
    
    /** @test */
    public function it_should_return_tag_response_when_parser_has_the_correct_params()
    {
        $this->shouldReturnTagsResponse([], '');
        $this->createTagParser([]);
        
        $this->assertEquals(
            [],
            $this->tagParser->parse('dd', function($post) {
                return $post;
            })
        );
    }
    
    public function createTagParser($post)
    {
        $this->tagParser
            ->shouldReceive([
                'parse' => null
            ])
            ->once()
            ->andReturn($post)
        ;
    }
    
    public function shouldReturnTagsResponse(
        array $requestOptions,
        string $expectedReturn
    )
    {
        $this->httpClient
            ->shouldReceive('get')
            ->with('/graphql/query/', $requestOptions)
            ->once()
            ->andReturn($expectedReturn)
        ;
    }
}