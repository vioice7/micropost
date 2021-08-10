<?php

namespace App\Entity;

use App\Repository\LikeNotificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeNotificationRepository::class)
 */
class LikeNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MicroPost")
     */
    private $microPost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $likedBy;

    /**
     * 
     */ 
    public function getMicroPost()
    {
        return $this->microPost;
    }

    /**
     * @return  self
     */ 
    public function setMicroPost($microPost)
    {
        $this->microPost = $microPost;

        return $this;
    }

    /**
     * 
     */ 
    public function getLikedBy()
    {
        return $this->likedBy;
    }

    /**
     * @return  self
     */ 
    public function setLikedBy($likedBy)
    {
        $this->likedBy = $likedBy;

        return $this;
    }
}
