<?php
/**
 */

namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class PublicationManager
{
    private $dateManager;
    private $entityManager;

    public function __construct(DateManager $dateManager, EntityManagerInterface $entityManager)
    {
        $this->dateManager = $dateManager;
        $this->entityManager = $entityManager;

    }

    public function setCreationAndUpdateDateToNow($entity)
    {
        if(is_null($entity->getCreationDate()))
        {
            $this->dateManager->setDateToNow('creation', $entity);
        }
        $this->dateManager->setDateToNow('update', $entity);
    }

    public function toDatabase($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

}