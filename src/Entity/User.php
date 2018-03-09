<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", Length=100)
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", Length=100)
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", Length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     */
    private $subscription_date;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject", mappedBy="users")
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resource", mappedBy="user")
     */
    private $resources;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Alert", mappedBy="user")
     */
    private $alert;

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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionDate()
    {
        return $this->subscription_date;
    }

    /**
     * @param mixed $subscription_date
     */
    public function setSubscriptionDate($subscription_date): void
    {
        $this->subscription_date = $subscription_date;
    }

    /**
     * @return mixed
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * @param mixed $subjects
     */
    public function setSubjects($subjects): void
    {
        $this->subjects = $subjects;
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

    /**
     * @return mixed
     */
    public function getAlert()
    {
        return $this->alert;
    }

    /**
     * @param mixed $alert
     */
    public function setAlert($alert): void
    {
        $this->alert = $alert;
    }
}
