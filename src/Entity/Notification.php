<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotificationRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"like" = "LikeNotification"})
 */
abstract class Notification 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seen;

    public function __construct()
    {
        $this->seen = false;
    }

    /**
     * @return mixed
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */ 
    public function getSeen()
    {
        return $this->seen;
    }

    /**
     * 
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * 
     *
     * @return  self
     */ 
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }
}
