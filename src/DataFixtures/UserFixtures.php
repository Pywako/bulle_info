<?php
/**
 */

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $password, $email, $isActive, $subscriptionDate, $roles])
        {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setIsActive($isActive);
            $user->setSubscriptionDate($subscriptionDate);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        $now = new \dateTime();
        return [
            ['tim', 'kitty5!','tomy@gmail.com',true, $now, ['ROLE_USER']],
            ['lena', 'Strangekitten','len@gmail.com',true, $now, ['ROLE_USER']],
            ['boardUser', 'Weirdkitten','userAdmin@gmail.com',true, $now, ['ROLE_ADMIN']],
        ];
    }


}