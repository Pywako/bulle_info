<?php
/**
 */

namespace App\Service;

use App\Entity\Resource;
use App\Entity\Subject;
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
        $this->session->set('' . $parameter . '', $data);
    }

    public function setCreationAndUpdateDateToNow($entity)
    {
        if (is_null($entity->getCreationDate())) {
            $this->dateManager->setDateToNow('creation', $entity);
        }
        $this->dateManager->setDateToNow('update', $entity);
    }

    public function hydrateSubject(Subject $subject)
    {
        $this->setCreationAndUpdateDateToNow($subject);
        $subject->setUser($this->user);
    }

    public function hydrateResource(Resource $resource, $subject = null)
    {
        if ($subject != null) {
            $resource->setSubject($subject);
        }
        $this->setCreationAndUpdateDateToNow($resource);
        $resource->setUser($this->user);

    }

    public function prepareEntitiesToPublish(Resource $resource, Subject $subject, $categorys = null)
    {
        $this->hydrateResource($resource, $subject);
        $this->hydrateSubject($subject);
        if ($categorys != null) {
            foreach ($categorys as $category) {
                $category->addSubject($subject);
            }
        }
        $resource->setSubject($subject);
    }

    public function pushEntitiesToDatabase($resource, $subject, $categorys)
    {
        $this->toDatabase($resource);
        $this->toDatabase($subject);
        foreach ($categorys as $category) {
            $this->toDatabase($category);
        }
    }

    public function toDatabase($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}