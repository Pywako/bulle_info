<?php
/**
 */

namespace App\Service;

use App\Entity\Subject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PublicationManager
{
    private $dateManager;
    private $entityManager;
    private $user;

    public function __construct(DateManager $dateManager, EntityManagerInterface $entityManager,
                                TokenStorageInterface $tokenStorage)
    {
        $this->dateManager = $dateManager;
        $this->entityManager = $entityManager;
        $this->user = $tokenStorage->getToken()->getUser();

    }

    public function setCreationAndUpdateDateToNow($entity)
    {
        if(is_null($entity->getCreationDate()))
        {
            $this->dateManager->setDateToNow('creation', $entity);
        }
        $this->dateManager->setDateToNow('update', $entity);
    }

    public function prepareResourceToPublish($resource)
    {
        $subject = $resource->getSubject();

        $this->setCreationAndUpdateDateToNow($subject);
        $subject->setUser($this->user);
        //TODO Add category to subject

        $this->setCreationAndUpdateDateToNow($resource);
        $resource->setUser($this->user);
    }

    public function toDatabase($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}