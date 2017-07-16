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
 * Class InstagramPost
 *
 * @package Mineur\InstagramParser\Model
 */
class InstagramPost
{
    /** @var int */
    private $id;
    
    /** @var string */
    private $comment;
    
    /** @var int */
    private $commentsCount;
    
    /** @var array */
    private $tags = [];
    
    /** @var string */
    private $shortCode;
    
    /** @var string */
    private $takenAtTimestamp;
    
    /** @var array */
    private $dimensions;
    
    /** @var int */
    private $likesCount;
    
    /** @var string */
    private $mediaSrc;
    
    /** @var string */
    private $thumbnailSrc;
    
    /** @var string */
    private $ownerId;
    
    /** @var bool */
    private $video;
    
    /** @var bool|null */
    private $commentsDisabled;
    
    /** @var string|null */
    private $hashReference;
    
    /**
     * InstagramPost constructor.
     *
     * @param int             $id
     * @param string          $comment
     * @param int             $commentsCount
     * @param TagCollection   $tags
     * @param string          $shortCode
     * @param string          $takenAtTimestamp
     * @param MediaDimensions $dimensions
     * @param int             $likesCount
     * @param string          $mediaSrc
     * @param string          $thumbnailSrc
     * @param string          $ownerId
     * @param bool            $video
     * @param bool|null       $commentsDisabled
     * @param null|string     $hashReference
     */
    private function __construct(
        int $id,
        ? string $comment,
        int $commentsCount,
        TagCollection $tags,
        string $shortCode,
        string $takenAtTimestamp,
        MediaDimensions $dimensions,
        int $likesCount,
        string $mediaSrc,
        string $thumbnailSrc,
        string $ownerId,
        bool $video,
        ? bool $commentsDisabled,
        ? string $hashReference
    )
    {
        $this->id               = $id;
        $this->comment          = $comment;
        $this->commentsCount    = $commentsCount;
        $this->tags             = $tags;
        $this->shortCode        = $shortCode;
        $this->takenAtTimestamp = $takenAtTimestamp;
        $this->dimensions       = $dimensions;
        $this->likesCount       = $likesCount;
        $this->mediaSrc         = $mediaSrc;
        $this->thumbnailSrc     = $thumbnailSrc;
        $this->ownerId          = $ownerId;
        $this->video            = $video;
        $this->commentsDisabled = $commentsDisabled;
        $this->hashReference    = $hashReference;
    }
    
    /**
     * Create Instagram Post Object from array
     *
     * @param array $instagramPost
     * @return InstagramPost
     */
    public static function fromArray(array $instagramPost)
    {
        return new self(
            (int) $instagramPost['id'],
            $instagramPost['edge_media_to_caption']['edges'][0]['node']['text'] ?? null,
            $instagramPost['edge_media_to_comment']['count'],
            TagCollection::fromString(
                $instagramPost['edge_media_to_caption']['edges'][0]['node']['text'] ?? null
            ),
            $instagramPost['shortcode'],
            $instagramPost['taken_at_timestamp'],
            MediaDimensions::fromArray(
                $instagramPost['dimensions']
            ),
            (int) $instagramPost['edge_liked_by']['count'],
            $instagramPost['display_url'],
            $instagramPost['thumbnail_src'],
            $instagramPost['owner']['id'],
            $instagramPost['is_video'],
            $instagramPost['comments_disabled'],
            $instagramPost['hash_reference'] ?? null
        );
    }
    
    /**
     * Return Instagram Post object to Array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id'                 => $this->id,
            'comment'            => $this->comment,
            'comments_count'     => $this->commentsCount,
            'tags'               => $this->tags->getTags(),
            'short_code'         => $this->shortCode,
            'taken_at_timestamp' => $this->takenAtTimestamp,
            'dimensions'         => $this->dimensions->toArray(),
            'likes_count'        => $this->likesCount,
            'media_src'          => $this->mediaSrc,
            'thumbnail_src'      => $this->thumbnailSrc,
            'owner_id'           => $this->ownerId,
            'video'              => $this->video,
            'comments_disabled'  => $this->commentsDisabled,
            'hash_reference'     => $this->hashReference
        ];
    }
    
    /**
     * Return serialized Instagram Post object
     *
     * @return string
     */
    public function serialized(): string
    {
        return serialize(
            new self(
                $this->id,
                $this->comment,
                $this->commentsCount,
                $this->tags,
                $this->shortCode,
                $this->takenAtTimestamp,
                $this->dimensions,
                $this->likesCount,
                $this->mediaSrc,
                $this->thumbnailSrc,
                $this->ownerId,
                $this->video,
                $this->commentsDisabled,
                $this->hashReference
            )
        );
    }
    
    /** @return int */
    public function getId(): int
    {
        return $this->id;
    }
    
    /** @return null|string */
    public function getComment(): ? string
    {
        return $this->comment;
    }
    
    /** @return int */
    public function getCommentsCount(): int
    {
        return $this->commentsCount;
    }
    
    /** @return array */
    public function getTags(): array
    {
        return $this->tags->getTags();
    }
    
    /** @return string */
    public function getShortCode(): string
    {
        return $this->shortCode;
    }
    
    /** @return string */
    public function getTakenAtTimestamp(): string
    {
        return $this->takenAtTimestamp;
    }
    
    /** @return array */
    public function getDimensions(): array
    {
        return $this->dimensions;
    }
    
    /** @return string */
    public function getLikesCount()
    {
        return $this->likesCount;
    }
    
    /** @return string */
    public function getMediaSrc(): string
    {
        return $this->mediaSrc;
    }
    
    /** @return string */
    public function getThumbnailSrc(): string
    {
        return $this->thumbnailSrc;
    }
    
    /** @return string */
    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
    
    /** @return bool */
    public function isVideo(): bool
    {
        return $this->video;
    }
    
    /** @return bool|null */
    public function getCommentsDisabled(): ? bool
    {
        return $this->commentsDisabled;
    }
    
    /** @return bool|null */
    public function getHashReference(): ? string
    {
        return $this->hashReference;
    }
    
    /** @param string $hashReference */
    public function setHashReference(string $hashReference)
    {
        $this->hashReference = $hashReference;
    }
}