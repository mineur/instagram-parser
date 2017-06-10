<?php

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
     * @param int       $id
     * @param string    $comment
     * @param int       $commentsCount
     * @param string    $shortCode
     * @param string    $takenAtTimestamp
     * @param array     $dimensions
     * @param int       $likesCount
     * @param string    $mediaSrc
     * @param string    $thumbnailSrc
     * @param string    $ownerId
     * @param bool      $video
     * @param bool|null $commentsDisabled
     */
    private function __construct(
        int $id,
        string $comment,
        int $commentsCount,
        string $shortCode,
        string $takenAtTimestamp,
        array $dimensions,
        int $likesCount,
        string $mediaSrc,
        string $thumbnailSrc,
        string $ownerId,
        bool $video,
        ? bool $commentsDisabled
    )
    {
        $this->id = $id;
        $this->comment = $comment;
        $this->commentsCount = $commentsCount;
        $this->shortCode = $shortCode;
        $this->takenAtTimestamp = $takenAtTimestamp;
        $this->dimensions = $dimensions;
        $this->likesCount = $likesCount;
        $this->mediaSrc = $mediaSrc;
        $this->thumbnailSrc = $thumbnailSrc;
        $this->ownerId = $ownerId;
        $this->video = $video;
        $this->commentsDisabled = $commentsDisabled;
    }
    
    public function fromArray(array $instagramPost)
    {
        return new self(
            $instagramPost['id'],
            $instagramPost['comment'],
            $instagramPost['commentsCount'],
            $instagramPost['shortCode'],
            $instagramPost['takenAtTimestamp'],
            $instagramPost['dimensions'],
            $instagramPost['likesCount'],
            $instagramPost['mediaSrc'],
            $instagramPost['thumbnailSrc'],
            $instagramPost['ownerId'],
            $instagramPost['video'],
            $instagramPost['commentsDisabled']
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