<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=100)
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
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="subjects")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", mappedBy="subjects")
     */
    private $categorys;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resource", mappedBy="subject")
     */
    private $resources;

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
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users): void
    {
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function getCategorys()
    {
        return $this->categorys;
    }

    /**
     * @param mixed $categorys
     */
    public function setCategorys($categorys): void
    {
        $this->categorys = $categorys;
    }

    /**
     * @return mixed
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param mixed $resources
     */
    public function setResources($resources): void
    {
        $this->resources = $resources;
    }
}
