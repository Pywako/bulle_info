<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements AdvancedUserInterface, \Serializable
{
    const DEFAULT_ROLE = 'ROLE_USER';
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank(message="le pseudo doit être rempli")
     */
    private $username;
    /**
     *
     * @Assert\NotBlank(message="Les champs mot de passe doit être rempli")
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @Assert\NotBlank(groups={"changePassword"})
     * @Assert\Length(min=8, groups={"changePassword"})
     * @Assert\NotNull(groups={"changePassword"})
     */
    private $oldPassword;

    /**
     * @Assert\NotBlank(groups={"changePassword"})
     * @Assert\Length(min=8, groups={"changePassword"} )
     * @Assert\NotNull(groups={"changePassword"})
     */
    private $newPassword;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Length(min=8, minMessage="mot de passe trop court")
     */
    private $password;

    /**
     *
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\NotBlank(message="Le champs email doit être rempli")
     * @Assert\Email(message="veuillez entrer un email de type nom@email.com")
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var /Datetime
     *
     * @ORM\Column(type="datetime")
     */
    private $subscription_date;

    /**
     * @var array
     * @ORM\Column(type="string")
     *
     */
    private $roles = [self::DEFAULT_ROLE];

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subject", mappedBy="users")
     */
    private $subjects;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Resource", mappedBy="user")
     */
    private $resources;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Alert", mappedBy="user")
     */
    private $alert;

    public function construct()
    {
        $this->isActive = true;
        $this->roles = [];
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
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
     *
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return mixed
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setOldPassword($oldPassword): void
    {
        $this->oldPassword = $oldPassword;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }


    /**
     *
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        //bcrypt don't require a separate salt
        return null;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        if(empty($roles)){
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }

    public function eraseCredentials()
    {
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->isActive,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->isActive,
            ) = unserialize($serialized);
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
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

    public function isAccountNonExpired()
    {
        return true;
    }
    public function isAccountNonLocked()
    {
        return true;
    }
    public function isCredentialsNonExpired()
    {
        return true;
    }
    public function isEnabled()
    {
        return $this->isActive;
    }
}
