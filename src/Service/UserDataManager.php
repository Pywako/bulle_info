<?php
/**
 */

namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataManager
{

    private $session;
    private $entityManager;
    private $passwordEncode;
    private $dateManager;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder, DateManager $dateManager)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->passwordEncode = $passwordEncoder;
        $this->dateManager = $dateManager;
    }

    public function createUser()
    {
        return $user = new User();
    }

    public function encodePassword($passwordName, User $user)
    {
        $passwordGetter = 'get' . ucfirst($passwordName);
        $passwordToSet = $user->$passwordGetter();

        $password = $this->passwordEncode->encodePassword($user, $passwordToSet);
        $user->setPassword($password);
    }

    public function hydrateforRegistration(User $user)
    {
        $this->encodePassword("plainPassword", $user);
        $this->dateManager->setDateToNow('subscription', $user);
        $user->setIsActive(true);

        return $user;
    }

    public function toDatabase($user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }


}
