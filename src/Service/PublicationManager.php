<?php
/**
 */

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PublicationManager
{
    private $dateManager;
    private $entityManager;
    private $user;
    private $session;

    public function __construct(DateManager $dateManager, EntityManagerInterface $entityManager,
                                TokenStorageInterface $tokenStorage, SessionInterface $session)
    {
        $this->dateManager = $dateManager;
        $this->entityManager = $entityManager;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->session = $session;

    }

    public function getDataInSession($data)
    {
        $publication = $this->session->get('' . $data . '');
        return $publication;
    }

    public function setInSession($parameter, $data)
    {
        $this->session->set(''. $parameter .'', $data);
    }

    public function setCreationAndUpdateDateToNow($entity)
    {
        if (is_null($entity->getCreationDate())) {
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