<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 */
class Subject
{
    const NUMBER_SUBJECT_DISPLAY_MAX = 10;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime", length=100)
     */
    private $creationDate;

    /**
     * @ORM\Column(type="datetime", length=100)
     */
    private $updateDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="subjects")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resource", mappedBy="subject", cascade={"remove"})
     */
    private $resources;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", mappedBy="subjects", cascade={"persist"})
     */
    private $categorys;

    public function __construct()
    {
        $this->resources = new ArrayCollection();
        $this->categorys = new ArrayCollection();
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate($creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param mixed $updateDate
     */
    public function setUpdateDate($updateDate): void
    {
        $this->updateDate = $updateDate;
    }


    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection|Resource[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategorys()
    {
        return $this->categorys;
    }

    /**
     *
     */
    public function addCategory($category): void
    {
        $this->categorys[] = $category;
    }



}
