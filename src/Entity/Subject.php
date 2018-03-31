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
    private $creation_date;

    /**
     * @ORM\Column(type="datetime", length=100)
     */
    private $update_date;

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
        return $this->creation_date;
    }

    /**
     * @param mixed $creation_date
     */
    public function setCreationDate($creation_date): void
    {
        $this->creation_date = $creation_date;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->update_date;
    }

    /**
     * @param mixed $update_date
     */
    public function setUpdateDate($update_date): void
    {
        $this->update_date = $update_date;
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
