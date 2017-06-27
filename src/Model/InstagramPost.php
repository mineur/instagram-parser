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

class InstagramPost
{
    /** @var int */
    private $id;
    
    /** @var string */
    private $comment;
    
    /** @var int */
    private $commentsCount;
    
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
    
    /**
     * InstagramPost constructor.
     *
     * @param int             $id
     * @param string          $comment
     * @param int             $commentsCount
     * @param string          $shortCode
     * @param string          $takenAtTimestamp
     * @param MediaDimensions $dimensions
     * @param int             $likesCount
     * @param string          $mediaSrc
     * @param string          $thumbnailSrc
     * @param string          $ownerId
     * @param bool            $video
     * @param bool|null       $commentsDisabled
     */
    private function __construct(
        int $id,
        ? string $comment,
        int $commentsCount,
        string $shortCode,
        string $takenAtTimestamp,
        MediaDimensions $dimensions,
        int $likesCount,
        string $mediaSrc,
        string $thumbnailSrc,
        string $ownerId,
        bool $video,
        ? bool $commentsDisabled
    )
    {
        $this->id               = $id;
        $this->comment          = $comment;
        $this->commentsCount    = $commentsCount;
        $this->shortCode        = $shortCode;
        $this->takenAtTimestamp = $takenAtTimestamp;
        $this->dimensions       = $dimensions;
        $this->likesCount       = $likesCount;
        $this->mediaSrc         = $mediaSrc;
        $this->thumbnailSrc     = $thumbnailSrc;
        $this->ownerId          = $ownerId;
        $this->video            = $video;
        $this->commentsDisabled = $commentsDisabled;
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
            $instagramPost['comments_disabled']
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
            'short_code'         => $this->shortCode,
            'taken_at_timestamp' => $this->takenAtTimestamp,
            'dimensions'         => $this->dimensions->toArray(),
            'likes_count'        => $this->likesCount,
            'media_src'          => $this->mediaSrc,
            'thumbnail_src'      => $this->thumbnailSrc,
            'owner_id'           => $this->ownerId,
            'video'              => $this->video,
            'comments_disabled'  => $this->commentsDisabled
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
                $this->shortCode,
                $this->takenAtTimestamp,
                $this->dimensions,
                $this->likesCount,
                $this->mediaSrc,
                $this->thumbnailSrc,
                $this->ownerId,
                $this->video,
                $this->commentsDisabled
            )
        );
    }
    
    /** @return int */
    public function getId(): int
    {
        return $this->id;
    }
    
    /** @return string */
    public function getComment(): string
    {
        return $this->comment;
    }
    
    /** @return int */
    public function getCommentsCount(): int
    {
        return $this->commentsCount;
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
    public function getCommentsDisabled()
    {
        return $this->commentsDisabled;
    }
}